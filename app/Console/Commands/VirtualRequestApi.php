<?php

namespace App\Console\Commands;

use App\Livewire\Admin\Payout\PayoutRequest;
use App\Models\ApiLog;
use App\Models\FundRequest;
use App\Models\PayoutRequestHistory;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\VirtualRequest;
use Illuminate\Console\Command;

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
        /* $url="https://indusapi.indusind.com/indusapi/prod/iec/etender/getTenderId";
        do{
            $transactionId = "NE".rand(11111111111,99999999999);
        }while(VirtualRequest::where('reference_number',$transactionId)->first() instanceOf VirtualRequest);

        $parameter=[
            'request'=>[
                'header'=>[
                    'requestUUID'=>$transactionId,
                    "channelId"=> "IND"
                ],
                'body'=>[
                    'fetchIECDataReq'=>[
                        'customerTenderId'=>'GROSC'
                        ]
                ]
            ]
        ];
        $header=array(
            'IBL-Client-Id'=>'d7742ee2e89e1c60ae2f1eb033f1d085',
            'IBL-Client-Secret'=>'85133e04472f52a6e7da690cebed765c',
            'Content-Type'=>'application/json',
            // 'Cookie'=>'a0a0fc7cac20bee04202c73c1da5cebd=3c8e1ffd998dfdf64e707f197a03dea4 sess_map=quasucvdsdwfwevwuuxsdsvbwefbqzvfuxdfffzwrvcbbfesctuaqcvsbeefywtvvaaqryqvqebudsxzwbcwfarfewxzxqebfvtedxaqusffdvrbrstdztxsfsfyqvserrfbevccfuqwvefyruczayfv'
        );

        $response = apiCall($header,$url,$parameter,true,$transactionId);
        // dd($response['response']['body']['fetchIECDataRes']['responseIECData']);
        if($response['response']['body']['fetchIECDataRes']['responseIECData'] !='NODATA'):
            // $transactions=$response->response->body->fetchIECDataRes->responseIECData->transaction;
            $transactions=$response['response']['body']['fetchIECDataRes']['responseIECData']['transaction'];
            foreach($transactions as $transaction):
                $user=User::where('virtual_account_number',$transaction['creditAccountNo'])->first();
                $openingBalence = Wallet::where('user_id',$user->id)->first()->amount;
                VirtualRequest::create([
                    'user_id'=>$user->id,
                    'client_account_number'=>$transaction['clientAccountNo'],
                    'payment_method'=>$transaction['payMethod'],
                    'opening_amount'=>$openingBalence,
                    'credit_amount'=>$transaction['amount'],
                    'closing_amount'=>$transaction['amount']+$openingBalence,
                    'reference_number'=>$transactionId,
                    'remitter_name'=>$transaction['remitterName'],
                    'remitter_account_number'=>$transaction['remitterAccountNo'],
                    'remitter_ifsc_code'=>$transaction['remitterIFSC'],
                    'remitter_bank'=>$transaction['remitterBank'],
                    'remitter_branch'=>$transaction['remitterBranch'],
                    'remitter_utr'=>$transaction['remitterUTR'],
                    'credit_account_number'=>$transaction['creditAccountNo'],
                    'inward_refernce_number'=>$transaction['inwardRefNum'],
                    'credit_time'=>Carbon::parse($transaction['creditTime'])->format('Y-m-d H:i:s'),
                    'status_id'=>'2',
                ]);
                Wallet::where('user_id',$user->id)->update([
                    'amount'=>$transaction['amount']+$openingBalence
                ]);
            endforeach;
        endif; */
       /*  $poutuid =[];
        $fundRequests = FundRequest::orderBy('id','ASC')->get();
        foreach($fundRequests as $fundRequest):
            $checkFundRequestHistory = PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->get();
            if($checkFundRequestHistory->count() >0):
                echo "This record exist payout request history table fund_request_id:-".$fundRequest->id.PHP_EOL;
            else:
                echo "This record exist payout request history table fund_request_id:-".$fundRequest->id.PHP_EOL;
                $checkApiLog = ApiLog::where('txn_id',$fundRequest->payout_id)->first();
                if(is_null($checkApiLog)):
                    $poutuid []=$fundRequest->payout_id;
                    echo "This transaction not hit api trnsaction id:-".$fundRequest->payout_id.PHP_EOL;
                else:
                    echo "This transaction hit api trnsaction id:-".$fundRequest->id.PHP_EOL;
                endif;
            endif;
        endforeach;
        echo implode(',',$poutuid); */

        $f_pointer=fopen("/var/www/payout.csv",'r');
        $i =0;
        while(! feof($f_pointer)){
            $arr=fgetcsv($f_pointer);
            if($i !=0):
                $fundRequests = FundRequest::where('payout_id',$arr['1'])->first();
                // dd($fundRequests);
                $update = PayoutRequestHistory::where('fund_request_id',$fundRequests->id)->update([
                    'closing_balnce'=>$arr['6'],
                    'balance'=>$arr['3'],
                ]);
            endif;
            $i++;
        }
       

    }
}
