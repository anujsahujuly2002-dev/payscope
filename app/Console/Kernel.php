<?php

namespace App\Console;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
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
        $schedule->command('app:check-payment-status-command')->everyTwoMinutes();
        $getStaturday = $this->getSaturdaysOfCurrentMonth();
        // Search for the key of a specific date
        $days = [1,2,3,4,5];
        $searchDate = date('Y-m-d');
        $key = array_search($searchDate, $getStaturday);
        if ($key !== false) {
            $noOfWeek = $key+1;
            if(in_array($noOfWeek,[1,3,5])):
                $days[] = 6;
            endif;
        }  
        $schedule->command('app:auto-transaction-update-webhook')->everySecond();
        $schedule->command('app:fetch-razorpay-qr-status-command')->everyMinute();
        $schedule->command('app:auto-payin-transaction-update-webhook')->everySecond();
        $schedule->command('app:payment-settlement-command')->daily()->at('10:00')->when(function () use($days){
            $today = Carbon::today();
            $weekDays = [];
            for ($i = 0; $i < 7; $i++) {
                $weekDays[$i+1] = $today->copy()->startOfWeek()->addDays($i)->format('l'); // 'l' gives the full name of the day
            }
            // Get the current day name
            $currentDayName = $today->format('l'); // 'l' gives the full day name
            // Search for the key of "Wednesday"
            $key = array_search($currentDayName, $weekDays);
            return in_array($key, $days);
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

    protected function getSaturdaysOfCurrentMonth() {
        $saturdays = [];

        // Get the first day of the current month
        $startDate = new DateTime('first day of this month');
    
        // Get the last day of the current month
        $endDate = new DateTime('last day of this month');
    
        // Create a DatePeriod for every Saturday
        $interval = new DateInterval('P1D'); // 1-day interval
        $period = new DatePeriod($startDate, $interval, $endDate);
    
        // Loop through the period and check if the day is Saturday
        foreach ($period as $date) {
            if ($date->format('N') == 6) { // 'N' returns the ISO-8601 numeric representation of the day (6 = Saturday)
                $saturdays[] = $date->format('Y-m-d');
            }
        }
        return $saturdays;
    }
}
