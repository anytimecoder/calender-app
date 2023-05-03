<?php

namespace App\Console;

use App\Console\Commands\SendEmail;
use App\Console\Commands\SyncEvents;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // sync events a bit earlier
        $schedule->command(SyncEvents::class)->dailyAt('07:45');
        $schedule->command(SendEmail::class)->dailyAt('07:59');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
