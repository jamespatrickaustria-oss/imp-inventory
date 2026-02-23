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
        // Generate and send weekly report every Monday at 8:00 AM
        $schedule->command('report:weekly --send')
            ->weeklyOn(1, '08:00') // Monday at 8:00 AM
            ->description('Generate and send weekly inventory report');

        // Alternative: Generate daily at 1:00 AM for on-demand sending
        // $schedule->command('report:weekly')
        //     ->dailyAt('01:00')
        //     ->description('Generate daily inventory report');
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
