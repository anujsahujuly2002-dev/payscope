<?php

namespace App\Console\Commands;

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
        $url="https://indusapi.indusind.com/indusapi/prod/iec/etender/getTenderId";
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
        endif;
    }
}
