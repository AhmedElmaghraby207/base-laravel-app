<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientDevice extends Model
{
    protected $fillable = [
        'PatientId',
        'device_unique_id',
        'token',
        'firebase_token',
        'is_logged_in',
        'mobile_os',
        'mobile_model'
    ];

    public function patient()
    {
        return $this->belongsTo('App\Patient', 'PatientId');
    }
}
