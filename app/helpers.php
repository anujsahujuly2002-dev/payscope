<?php


use App\Models\ApiLog;
use App\Models\Scheme;
use App\Models\Wallet;
use App\Models\Setting;
use App\Models\Retailer;
use App\Models\ApiPartner;
use App\Models\Commission;
use App\Models\PaymentMode;
use App\Models\OperatorManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;



if(!function_exists('apiCall')):
    function apiCall($headers,$url,$prameter,$log=false,$txn_id=null,$headerType='') {
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
            dd($e);
            return $e->getMessage();
        }

    }
endif;
if(!function_exists('apiCallWitBody')):
    function apiCallWitBody($headers,$url,$prameter,$log=false,$txn_id=null) {
        try {
                $response = Http::withHeaders($headers)->withBody($prameter, 'application/x-www-form-urlencoded')->post($url);
                $res = $response->json();
            if($log):
                ApiLog::create([
                    'url'=>$url,
                    'txn_id'=>$txn_id,
                    'header'=>json_encode($headers),
                    'request'=>json_encode($prameter),
                    'response'=> json_encode($response->json()),
                ]);
            endif;
            return $res;
        } catch (\Exception $e) {
            dd($e);
            return $e->getMessage();
        }

    }
endif;


if(!function_exists('getCommission')):
    function getCommission ($operaterType,$amount,$user_id) {
        $charges = 0.00;
        $commission = null;
        $schemeId = ApiPartner::where('user_id',$user_id)->first()->scheme_id??Retailer::where('user_id',$user_id)->first()->scheme_id;
        $scheme = OperatorManager::where('operator_type',$operaterType)->where('charge_range_start','<=',$amount)->where('charge_range_end','>=',$amount)->where('status','1')->first();
        if(!is_null($scheme) && !is_null($schemeId)):
            $commission = Commission::where(['slab_id'=>$scheme->id,'scheme_id'=>$schemeId])->first();
        endif;
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

if(!function_exists('getSettingValue')):
    function getSettingValue($settingKey) {
        $settingRec = Setting::where('key', $settingKey)->first();
        return ($settingRec) ? $settingRec->value : null;
    }
endif;

if(!function_exists('getAllWalletBalances')):
    function getAllWalletBalances() {
        return Wallet::sum('amount');
    }
endif;

if(!function_exists('moneyFormatIndia')):
    function moneyFormatIndia($amount) {
        list ($number, $decimal) = explode('.', sprintf('%.2f', floatval($amount)));

    $sign = $number < 0 ? '-' : '';

    $number = abs($number);

    for ($i = 3; $i < strlen($number); $i += 3)
    {
        $number = substr_replace($number, ',', -$i, 0);
    }

    return $sign . $number . '.' . $decimal;
}

endif;

if (!function_exists('formatAmount')) {
  function formatAmount($amount) {
        if ($amount >= 10000000) {
            return [
                "unit"=>"Cr",
                "amount"=>number_format($amount / 10000000, 2),
            ];
        } elseif ($amount >= 100000) {
            return [
                "unit"=>"L",
                "amount"=>number_format($amount / 100000, 2),
            ];
        } elseif ($amount >= 1000) {
            return[
                "unit"=>"K",
                "amount"=> number_format($amount / 1000, 2),
            ];
        } else {
            return $amount;
        }
    }
}
