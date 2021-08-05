<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuth
{
    public function handle($request, Closure $next, $guard = null)
    {
        $user_admin = $request->session()->get('user_admin');
        if (!$user_admin) {
            if ($request->ajax() || $request->wantsJson())
                return response('Unauthorized', 401);
            else
                return redirect()->guest(route('admin.get_login') . '?return_url=' . url()->current());
        }
        return $next($request);
    }

}
