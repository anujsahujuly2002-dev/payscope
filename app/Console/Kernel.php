<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\VirtualRequestApi;
use App\Console\Commands\CheckPaymentStatusCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands =[
        VirtualRequestApi::class,
        CheckPaymentStatusCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:check-payment-status-command')->everyMinute()->onSuccess(function () {
            $msg = "Check Payment Status Api Initiate Successfully";

            // use wordwrap() if lines are longer than 70 characters
            $msg = wordwrap($msg,70);
    
            // send email
            mail("programmeranuj930@gmail.com","Check Payment Status",$msg);
        });
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
