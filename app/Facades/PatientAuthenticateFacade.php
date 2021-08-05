<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PatientAuthenticateFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'App\Auth\Api\v1\PatientAuthentication';
    }
}
