<?php

namespace App\Console;

use App\Console\Commands\DatabaseBackup;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('demo:cron')->everyTwoMinutes();
        $schedule->command(DatabaseBackup::class)->everyTwoMinutes(); // Backup setiap hari pukul 02:00

        // $schedule->command('emails:send')->everyTenMinutes();

        // $schedule->call(function () {
        //     Log::info('Task Schedule by sl-maritime.com at : ' . date('Y-m-d H:i:s'));
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
