<?php

namespace App\Jobs;

use App\Notifications\P_DrinkWater;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DrinkWaterNotificationBackGround implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public function __construct()
    {
    }

    public function handle()
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            $patient->notify(new P_DrinkWater($patient));
        }
    }
}

