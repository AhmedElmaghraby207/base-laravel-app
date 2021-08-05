<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientRecover extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email',
        'hash',
        'password',
        'date_created'
    ];
}
