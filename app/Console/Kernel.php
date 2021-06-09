<?php

namespace App\Console;

use App\Console\Commands\InspectChecks;
use App\Console\Commands\RemoveExpiredChecks;
use App\Console\Commands\ResetChecks;
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
        InspectChecks::class,
        RemoveExpiredChecks::class,
        ResetChecks::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work --sleep=3 --tries=3')->everyMinute();
        $schedule->command('checks:inspect')->withoutOverlapping()->everyTenMinutes();
        $schedule->command('checks:expired')->withoutOverlapping()->hourly();
        $schedule->command('checks:reset')->withoutOverlapping()->hourly();
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
