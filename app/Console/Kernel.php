<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('demo:cron')->everyTwoMinutes();
        // $schedule->command('app:send-emails')->everyTwoMinutes();
        // $schedule->command('app:insurance-schedule-outomatic-h_60')->everyTwoMinutes();
        $schedule->command('app:insurance-renewal-insert-need-action-command')->everyTenSeconds();
        $schedule->command('app:insurance-renewal-notif-h_60-command')->everyteo();
        $schedule->command('app:insurance-renewal-notif-h_30-command')->everyMinute();
        $schedule->command('app:insurance-renewal-notif-h_10-command')->everyMinute();
        // $schedule->command('app:insurance-payment-notif-h_30-command')->everyMinute();
        // $schedule->command('app:insurance-payment-notif-h_15-command')->everyMinute();
        // $schedule->command('app:insurance-payment-notif-h_30-command')->everyMinute();
        // $schedule->command('app:insurance-payment-notif-h_15-command')->everyMinute();
        // $schedule->command('app:insurance-payment-notif-h_7-command')->everyMinute();
        $schedule->command('app:insurance-renewal-update-status-not-active-command')->everyMinute();
        $schedule->command('app:insurance-renewal-update-status-expired-command')->everyMinute();
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
