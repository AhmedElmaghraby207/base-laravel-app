<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    function __construct()
    {
        $this->middleware(['admin.auth'], ['except' => [
            'home',
            'get_login',
            'post_login',
            'getForgotPassword',
            'postForgotPassword',
            'getResetPassword',
            'postResetPassword',
        ]]);
    }
}
