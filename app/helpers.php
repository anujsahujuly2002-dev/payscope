<?php

use App\Models\ApiLog;
use App\Models\Scheme;
use App\Models\ApiPartner;
use App\Models\Commission;
use App\Models\OperatorManager;
use Illuminate\Support\Facades\DB;
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
            "X-Ipay-Client-Id"=>"YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=",
            "X-Ipay-Client-Secret"=>"ea5ffc2fd56497ba413e30fcc43a146d77fd208110bb7533d36de388256120df",
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

if(!function_exists('getPaymentModesId')):
    function getPaymentModesId ($name) {
       return $paymentModes = PaymentMode::where('name',$name)->first()->id;
    }
endif;

if(!function_exists('checkRecordHasPermission')):
    function checkRecordHasPermission($permission) {
        $userHasPermissionCount=DB::table("model_has_permissions")->where("model_has_permissions.model_id", auth()->user()->id)->count();
        if($userHasPermissionCount >0){
            if(is_array($permission)){
                $permissionId = DB::table('permissions')->whereIn('name',$permission)->pluck('id')->toArray();
            }else{
                $permissionId = DB::table('permissions')->whereIn('name',$permission)->pluck('id')->toArray();
            }
            $checkPermissonCount = DB::table("model_has_permissions")->whereIn("model_has_permissions.permission_id", $permissionId)->count();
            if($checkPermissonCount >0):
                return true;
            else:
                return false;
            endif;
        }else{
            return true;
        }
    }
endif;


if(!function_exists('sentOtp')):
    function sendOtp($mobile_no,$otp){
        $content = "Dear Partner, your login OTP for Grow Scope is {$otp} , please do not share otp with anyone. Regards, Payscope";
        $response = Http::get("https://instantalerts.co/api/web/send?apikey=".env('SMS_API_KEY')."&sender=".env('SENDER_ID')."&to=".$mobile_no."&message=".urlencode($content));
        if($response->successful()):
            return "success";
        endif;  
    }
endif;