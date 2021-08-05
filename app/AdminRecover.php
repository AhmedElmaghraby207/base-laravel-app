<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminRecover extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email',
        'hash',
        'password',
        'date_created'
    ];
}
