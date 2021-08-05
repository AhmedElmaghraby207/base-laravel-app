<?php

namespace App\Console\Commands;

use App\Notifications\P_DrinkWater;
use App\Patient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DrinkWaterNotificationsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drink_water_notification:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            $patient->notify(new P_DrinkWater($patient));
        }
        Log::info('drink_water_notification:cron');
    }
}
