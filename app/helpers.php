<?php

use App\Models\ApiLog;
use App\Models\ApiPartner;
use App\Models\Commission;
use App\Models\OperatorManager;
use App\Models\Scheme;
use Illuminate\Support\Facades\Http;

if(!function_exists('apiCall')):
    function apiCall($headers,$url,$prameter,$log=false,$txn_id) {
        try {
            $response = Http::retry(3, 100)->withHeaders($headers)->post($url,$prameter);
            $res = $response->getBody()->getContents();
            if($log):
                ApiLog::create([
                    'url'=>$url,
                    'txn_id'=>$txn_id,
                    'header'=>json_encode($headers),
                    'request'=>json_encode($prameter),
                    'response'=> $res,
                ]);
            endif;
            return json_decode($res,true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }
endif;


if(!function_exists('getCommission')):
    function getCommission ($operaterType,$amount,$user_id) {
        $charges = 0.00;
        $schemeId = ApiPartner::where('user_id',$user_id)->first()->scheme_id;
        $scheme = OperatorManager::where('operator_type',$operaterType)->where('charge_range_start','<=',$amount)->where('charge_range_end','>=',$amount)->where('status','1')->first();
        $commission = Commission::where(['slab_id'=>$scheme->id,'scheme_id'=>$schemeId])->first();
        if($commission !=null):
            if($commission->type =='0'):
                $charges = $amount*$commission->value/100;
            else:
                $charges = $commission->value;
            endif;
        endif;
        return $charges;
    }
endif;

if(!function_exists('getTelecomCircles')):
    function getTelecomCircles(){
        $url = "http://api.instantpay.in/marketplace/utilityPayments/telecomCircles";
        $headers =[
            "X-Ipay-Auth-Code"=> 1,
            "X-Ipay-Client-Id"=>"YWY3OTAzYzNlM2ExZTJlOfh549Gzt+5IEcETrD5Yx+Q=",
            "X-Ipay-Client-Secret"=>"679db35f926b8d0240a8c0d28729528ee8e6d5effa5fa0b20c04454004d2d825",
            "X-Ipay-Outlet-Id"=> "72762",
            "X-Ipay-Endpoint-Ip"=> request()->ip()
        ];
        $data = [
            "type" => "MSISDN",
            "msisdn" =>"941234",
            "billerId" => ""
        ];
        return apiCall($headers,$url,$data,true,NULL);
    }
endif;