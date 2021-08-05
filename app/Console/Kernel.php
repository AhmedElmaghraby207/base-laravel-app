<?php

namespace App\Console;

use App\Console\Commands\DrinkWaterNotificationsCron;
use App\Console\Commands\WalkNotificationsCron;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        WalkNotificationsCron::class,
        DrinkWaterNotificationsCron::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Sunday => 0
        //Monday => 1
        //Tuesday => 2
        //Wednesday => 3
        //Thursday => 4
        //Friday => 5
        //Saturday => 6

        $schedule->command('walk_notification:cron')->weeklyOn(6, '12:00'); //Saturday 2:00 pm in local

        $schedule->command('drink_water_notification:cron')->weeklyOn(3, '12:00'); //Wednesday 2:00 pm in local
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
