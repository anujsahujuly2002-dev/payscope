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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $f_pointer=fopen("/var/www/html/RevisedPayment.csv",'r');
        $i =0;
        while(! feof($f_pointer)){
            $arr=fgetcsv($f_pointer);
            // print_r($arr);
            if($i !=0):
                $fundRequests = FundRequest::where('payout_id',$arr['1'])->first();
                // dd($fundRequests);
                // dd($fundRequests);
                $update = PayoutRequestHistory::where('fund_request_id',$fundRequests->id)->update([
                    'closing_balnce'=>$arr['6'],
                    'balance'=>$arr['3'],
                ]);
            endif;
            $i++;
        }
        $pendingRequests = FundRequest::where('status_id','3')->whereIn('user_id',["9"])->orderBy('id','ASC')->get();
        // dd($pendingRequests->count());
       /*  $rejectedes =[
            'GROSC600358748588',
            'GROSC529662557402',
            'GROSC207556791009',
            'GROSC898816418788',
            'GROSC539476551420',
            'GROSC529767114007',
            'GROSC707559017368',
            'GROSC994675349205',
            'GROSC767816333006',
            'GROSC749295093814',
            'GROSC694261877600',
            'GROSC159146078002',
            'GROSC479441119378',
            'GROSC436173488665',
            'GROSC659951780788',
            'GROSC265019939359',
            'GROSC271521986427',
            'GROSC297357179110',
            'GROSC699539661635',
            'GROSC214537037718',
            'GROSC338764089049',
            'GROSC649963018985',
            'GROSC575011811016',
            'GROSC803314874924',
            'GROSC369918358445',
            'GROSC416581307384',
            'GROSC400645029384',
            'GROSC995434783214',
            'GROSC753755618713',
            'GROSC250610621677',
            'GROSC131449052628',
            'GROSC132653659726',
            'GROSC949903375668',
            'GROSC660667932754',
            'GROSC651246786493',
        ]; */
        /* $refunded = [
            'GROSC362077801900',
            'GROSC205273667376',
            'GROSC122985668236'
            'GROSC816827174004',
            'GROSC159308680371',
            'GROSC208483651162',
            'GROSC811706020454',
            'GROSC193510384312',
            'GROSC271763179793',
            'GROSC296633309057',
            'GROSC738426634423',
            'GROSC233173859432',
            'GROSC168978288266',
            'GROSC596608617318',
            'GROSC151237652560',
            'GROSC233593096998',
            'GROSC923807974470',
            'GROSC129991645446',
            'GROSC914407699082',
            'GROSC961805021183',
            'GROSC426651238612',
            'GROSC405519988651',
            'GROSC640733553011',
            'GROSC491472830396',
            'GROSC610469929290',
            'GROSC512711577021',
            'GROSC613782997402',
            'GROSC397142778984',
            'GROSC786797318884',
            'GROSC140146692878',
            'GROSC975703549090',
            'GROSC571841994836',
            'GROSC906298006801',
            'GROSC947281777825',
            'GROSC815734918806',
            'GROSC862120512888',
            'GROSC328125105102',
            'GROSC858142053873',
            'GROSC217119011651',
            'GROSC291168280825',
            'GROSC682470683103',
            'GROSC358594394640',
            'GROSC230325372070',
            'GROSC644230787730',
            'GROSC620440985058',
            'GROSC326410263230',
        ]; */
       /*  $refunded = [
            'GROSC721471815882',
            'GROSC225267507002',
            'GROSC396514347927',
            'GROSC848593798563',
            'GROSC241224251633'
        ]; */
        /* foreach ($pendingRequests as $key1 => $pendingPaymentRequest) :
            $checkApi = ApiLog::where('txn_id',$pendingPaymentRequest->payout_id)->first();
            if(!is_null($checkApi)):
                $apiUrl  = 'https://api.eko.in:25002/ekoicici/v1/transactions/client_ref_id:'.$pendingPaymentRequest->payout_id.'?initiator_id=9519035604';
                $key = "7865654c-2149-40d3-a184-aff404864a68";
                $encodedKey = base64_encode($key);
                $secret_key_timestamp =round(microtime(true) * 1000);
                $signature = hash_hmac('SHA256', $secret_key_timestamp, $encodedKey, true);
                $secret_key = base64_encode($signature);
                $header=array(
                    "developer_key"=>"a9a9bd9975d8237cdfc8a4ccdca33d0e",
                    "secret-key"=>$secret_key,
                    "secret-key-timestamp"=>$secret_key_timestamp,
                    "Content-Type"=>"application/x-www-form-urlencoded"
                );
                $response = Http::withHeaders($header)->get($apiUrl);
                $res = $response->json();
               if($res['status']=='69'):
                    $notHit []= $pendingPaymentRequest->payout_id;
               endif;
            else:
                $hit []= $pendingPaymentRequest->payout_id;
            endif;
        endforeach; */
       /*  Log::info("NOT HIT:-".implode(',',$notHit));
        Log::info("HIT:-".implode(',',$hit));
        echo count($notHit).PHP_EOL.count($hit); */
        /* $apiUrl  = 'https://api.eko.in:25002/ekoicici/v1/transactions/client_ref_id:GROSC795964853925?initiator_id=9519035604';
        $key = "7865654c-2149-40d3-a184-aff404864a68";
        $encodedKey = base64_encode($key);
        $secret_key_timestamp =round(microtime(true) * 1000);
        $signature = hash_hmac('SHA256', $secret_key_timestamp, $encodedKey, true);
        $secret_key = base64_encode($signature);
        $header=array(
            "developer_key"=>"a9a9bd9975d8237cdfc8a4ccdca33d0e",
            "secret-key"=>$secret_key,
            "secret-key-timestamp"=>$secret_key_timestamp,
            "Content-Type"=>"application/x-www-form-urlencoded"
        );
        $response = Http::withHeaders($header)->get($apiUrl);
        $res = $response->json();
        dd($res); */

        /* foreach($refunded as $es):
            $apiUrl  = 'https://api.eko.in:25002/ekoicici/v1/transactions/client_ref_id:'.$es.'?initiator_id=9519035604';
                $key = "7865654c-2149-40d3-a184-aff404864a68";
                $encodedKey = base64_encode($key);
                $secret_key_timestamp =round(microtime(true) * 1000);
                $signature = hash_hmac('SHA256', $secret_key_timestamp, $encodedKey, true);
                $secret_key = base64_encode($signature);
                $header=array(
                    "developer_key"=>"a9a9bd9975d8237cdfc8a4ccdca33d0e",
                    "secret-key"=>$secret_key,
                    "secret-key-timestamp"=>$secret_key_timestamp,
                    "Content-Type"=>"application/x-www-form-urlencoded"
                );
                $response = Http::withHeaders($header)->get($apiUrl);
                $res = $response->json();
                // print_r($res);
                $fundRequest=Fundrequest::where(['payout_id'=>$res['data']['client_ref_id'],'account_number'=>$res['data']['account'] ])->first();
                $fundRequestHistory = PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->first();
                Fundrequest::where('id',$fundRequest->id)->update([
                    'status_id'=>'2',
                    'payout_ref'=>$res['data']['tid'],
                    'utr_number'=>$res['data']['bank_ref_num']
                ]);
                PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                    'status_id'=>'2',
                    'closing_balnce'=>$fundRequestHistory->balance
                ]);
        endforeach; */
       /*  $pendingFundRequest = [];
        $fundRequests = FundRequest::whereIn('user_id',["9"])->where('status_id','2')->orderBy('id','ASC')->get();
        $PayoutRequestHistory = PayoutRequestHistory::whereIn('user_id',["9"])->where('status_id','2')->orderBy('id','ASC')->get();
        // dd($fundRequests->count(),$PayoutRequestHistory->count());
        // $fundRequestHistory = PayoutRequestHistory::whereIn('user_id',["9"])->orderBy('id','ASC')->get();

       foreach($fundRequests  as $key=> $fundRequest):
            echo ($key+1).PHP_EOL;
            echo $fundRequest->id.PHP_EOL;
            $fundRequestHistory = PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->where('status_id','1')->first();
            // Log::info([$fundRequest->id=>$fundRequestHistory->toArray()]);
            if(!is_null($fundRequestHistory)):
                $pendingFundRequest[] = $fundRequest->payout_id;
            endif;
       endforeach;

       Log::info(["pending payout"=>implode(',',$pendingFundRequest)]); */
       

    }
}
