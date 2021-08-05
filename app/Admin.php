<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;

    protected $table = 'admins';
    protected $guard_name = 'admin';

    protected $fillable = ['name', 'email', 'password', 'image'];

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset($value);
        }
        return asset("/uploads/defaults/admin.png");
    }
}
