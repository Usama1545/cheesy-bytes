<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:cart-age')->dailyAt('12:00');
        $schedule->command('check:cart-age')->dailyAt('22:00');
        $schedule->command('sitemap:generate')->daily();
        $schedule->command('deals:send-notifications')
            ->everyMinute()
            ->withoutOverlapping();
        $schedule->command('app:print-orders')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->command('app:delete-unpaid-pre-bookings')
            ->dailyAt('06:00')
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
