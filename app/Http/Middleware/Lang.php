<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Lang
{
    public function handle($request, Closure $next)
    {
        App::setLocale(Session::has('language') ? Session::get('language') : Config::get('app.locale'));
        return $next($request);
    }
}
