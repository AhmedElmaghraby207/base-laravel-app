<?php

namespace App\Auth\Api\v1;

use App\PatientDevice;

class PatientAuthentication
{
    protected $request;
    protected $patient;

    public function login()
    {
        $token = $this->request->header('x-auth-token');
        $patient_device = PatientDevice::where('token', $token)->where('is_logged_in', 1)->first();

        if ($patient_device != null) {
            $patient = $patient_device->patient;
            $this->patient = $patient;
        }

        if ($this->patient != null) {
            return true;
        } else {
            return false;
        }
    }

    public function patient()
    {
        return $this->patient;
    }

    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

}
