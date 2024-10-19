<?php

namespace App\Console;

use App\Console\Commands\VirtualRequestApi;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\CheckPaymentStatusCommand;
use App\Console\Commands\AutoTransactionUpdateWebhook;
use App\Console\Commands\FetchRazorpayQrStatusCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\AutoPayinTransactionUpdateWebhook;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands =[
        VirtualRequestApi::class,
        CheckPaymentStatusCommand::class,
        AutoTransactionUpdateWebhook::class,
        FetchRazorpayQrStatusCommand::class,
        AutoPayinTransactionUpdateWebhook::class
    ];

    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:check-payment-status-command')->everyFifteenMinutes()->onSuccess(function () {
            $msg = "Check Payment Status Api Initiate Successfully";
            // use wordwrap() if lines are longer than 70 characters
            $msg = wordwrap($msg,70);
            // send email
            mail("programmeranuj930@gmail.com","Check Payment Status",$msg);
        });

        $schedule->command('app:auto-transaction-update-webhook')->everyMinute();
        $schedule->command('app:fetch-razorpay-qr-status-command')->everyMinute();
        $schedule->command('app:auto-payin-transaction-update-webhook')->everyMinute();
        $schedule->command('app:payment-settlement-command')->daily()->at('18:00');


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
