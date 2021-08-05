<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Patient extends Model
{
    use Notifiable, HasRoles;

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImageAttribute($value): string
    {
        if ($value) {
            return asset($value);
        }
        if ($this->gender == 0) {
            return asset("/uploads/defaults/patient_female.jpg");
        } else {
            return asset("/uploads/defaults/patient_male.jpg");
        }
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branch_id');
    }

    public function firebase_tokens()
    {
        return Patient::where('email', $this->email)
            ->join('patient_devices', 'patients.id', '=', 'patient_devices.PatientId')
            ->where('is_logged_in', '1')
            ->get()
            ->pluck('firebase_token')
            ->toArray();
    }

    public function weights(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\PatientWeight', 'PatientId');
    }
}
