<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\TransactionHistory;
use App\Models\ApiLog;
use App\Models\Wallet;
use App\Models\FundRequest;
use App\Models\VirtualRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\QRPaymentCollection;
use App\Models\RazorapEventHistory;
use Illuminate\Support\Facades\Log;
use App\Models\PayoutRequestHistory;
use Illuminate\Support\Facades\Http;
use App\Livewire\Admin\Payout\PayoutRequest;

class VirtualRequestApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:virtual-request-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Virtual Paymnet Request Check IndusInd Bank';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $payoutRequests = FundRequest::where(['user_id'=>'10','status_id'=>'2'])->whereDate('created_at','2024-10-26')->whereNot('id','4284')->get();
        // dd( $payoutRequests);
       /*  foreach($payoutRequests as $payoutRequest):
            $fundRequestHistories = PayoutRequestHistory::where('fund_request_id',$payoutRequest->id)->first();
            $totalPayout = $fundRequestHistories->amount+$fundRequestHistories->charge+ $fundRequestHistories->gst;
            echo "Id:-".$payoutRequest->id.PHP_EOL."TOTAL PAYOUT:-". $totalPayout.PHP_EOL;
            echo "balance:-".$fundRequestHistories->balance.PHP_EOL."closing_balnce:-". $fundRequestHistories->closing_balnce.PHP_EOL;
            echo 'closing balance:-'.$fundRequestHistories->balance-$totalPayout.PHP_EOL;
            PayoutRequestHistory::where('fund_request_id',$payoutRequest->id)->update([
                'balance'=>$fundRequestHistories->balance,
                'closing_balnce'=>$fundRequestHistories->balance - $totalPayout
            ]); */
            // die;
            /*
            $payoutRequestHis =  PayoutRequestHistory::where('fund_request_id',$payoutRequest->id)->first();
            // dd($payoutRequestHis->balance);
            TransactionHistory::where('transaction_id',$payoutRequest->payout_id)->update([
                'opening_balance'=>$payoutRequestHis->balance,
                'amount'=>$totalPayout,
                'closing_balnce'=>$payoutRequestHis->closing_balnce
            ]); */
        // endforeach;

        $f_pointer=fopen("/var/www/groscope/correction.csv",'r');
        $i =0;
        while(! feof($f_pointer)){
            $arr=fgetcsv($f_pointer);
            print_r($arr);
            if($i !=0):
        //     TransactionHistory::where('transaction_id',$payoutRequest->payout_id)->update([
                // $fundRequests = FundRequest::where('payout_id',$arr['1'])->first();
                // // dd($fundRequests);
                // echo "Sr No.:-".($i+1).PHP_EOL;
                // echo "Fund Request Id:-".$fundRequests->id.PHP_EOL.
                // $update = PayoutRequestHistory::where('fund_request_id',$fundRequests->id)->update([
                //     'balance'=>$arr['3'],
                //     'amount'=>$arr['4'],
                //     'charge'=>$arr['5'],
                //     'gst'=>$arr['6'],
                //     'closing_balnce'=>$arr['7'],
                // ]);

                TransactionHistory::where('transaction_id',$arr['1'])->update([
                    'opening_balance'=>$arr['2'],
                    'amount'=>$arr['3'],
                    'closing_balnce'=>$arr['4']
                ]);
            endif;
            $i++;
        }
        // $payoutRequests = FundRequest::where(['user_id'=>'10'])->where('id','>=','5321')->get();
        // foreach($payoutRequests as $payoutRequest):
        //     $fundRequestHistories = PayoutRequestHistory::where('fund_request_id',$payoutRequest->id)->first();
        //     // dd($fundRequestHistories);
            /* TransactionHistory::where('transaction_id',$payoutRequest->payout_id)->update([
                'opening_balance'=>$fundRequestHistories->balance,
                'amount'=>$fundRequestHistories->amount+$fundRequestHistories->charge+$fundRequestHistories->gst,
                'closing_balnce'=>$fundRequestHistories->closing_balnce
            ]); */
        // endforeach;
        /* $fundRequestHistories = PayoutRequestHistory::where('fund_request_id','>=','4322')->where('status_id','3')->get();
        foreach($fundRequestHistories as $fundRequestsHistory):
            $fundRequests =FundRequest::where('id',$fundRequestsHistory->fund_request_id)->first();
            $transactionHistory = TransactionHistory::where('transaction_id',  $fundRequests->payout_id)->get();
            foreach($transactionHistory as $tra):
                /* echo "fund request history id: ".$fundRequests->id.PHP_EOL;
                if($tra->transaction_type=='credit'):
                    $fundRequestHist = PayoutRequestHistory::where('fund_request_id',$fundRequests->id)->first();
                    echo "fund request history id: ".$fundRequests->id.PHP_EOL;
                else:
                    echo "fund request history id Debit: ".$fundRequests->id.PHP_EOL;
                endif; */
            /* endforeach; */

       /*  endforeach;  */
        // $amount = "48400";
    //    TransactionHistory::create([
    //         'user_id'=>'10',
    //         'transaction_id'=>'GROSC386400541299',
    //         'opening_balance'=>"83401.72",
    //         'amount'=>$amount,
    //         'closing_balnce'=>($amount+83401.72)
    //    ]);


    }
}
