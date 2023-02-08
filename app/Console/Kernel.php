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
        $schedule->command('import:sheets')->timezone('EET')->dailyAt('07:00')->withoutOverlapping();
        $schedule->command('import:properties')->timezone('EET')->dailyAt('07:15')->withoutOverlapping();
        $schedule->command('import:calendar')->timezone('EET')->hourly()->withoutOverlapping();
        //$schedule->command('import:confirm-properties')->timezone('EET')->hourly();
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
