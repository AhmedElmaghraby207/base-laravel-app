<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Controllers\Api\v1\ApiController as BaseController;

abstract class PatientApiController extends BaseController
{
    function __construct()
    {
        $this->middleware('patient.auth', ['except' => [
            'login',
            'signup',
            'forgotPassword',
            'resendEmailVerification',
            'signupSocial',
            'operationsList',
            'branchesList'
        ]]);
    }
}
