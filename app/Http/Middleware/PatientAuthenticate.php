<?php

namespace App\Http\Middleware;

use App\Facades\PatientAuthenticateFacade as PatientAuth;
use App\Traits\Response;
use Closure;
use Illuminate\Support\Facades\Validator;

class PatientAuthenticate
{
    use Response;

    public function handle($request, Closure $next)
    {
        $headers = [];
        $headers['token'] = $request->header('x-auth-token');
        $headers['langCode'] = $request->header('x-lang-code');

        $validator = Validator::make($headers, [
            'token' => 'string|required',
            'langCode' => 'string'
        ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        }

        PatientAuth::setRequest($request);

        if (!PatientAuth::login())
            return self::errify(401, ['errors' => ['auth.invalid_token']]);

        return $next($request);
    }
}
