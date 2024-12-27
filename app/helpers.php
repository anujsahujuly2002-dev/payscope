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
use App\Models\TransactionHistory;
use App\Models\UserActivityLog;
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
            return [
                'status'=>false,
                'statusCode'=>$e->getCode(),
                'msg'=>$e->getMessage(),
            
            ];
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
        $gstCharges = 0.00;
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
            if($commission->gst ==='1'):
                $gstCharges = $charges*18/100;
            endif;
        endif;
        return [
            'payout_charges' =>$charges,
            'gst_charge'=>$gstCharges,
        ];
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
    $amountInCrores = $amount / 100000;
    // Optional: Format the result to two decimal places
    return number_format($amountInCrores,2);
    
    }
}


if(!function_exists('addTransactionHistory')):
    function  addTransactionHistory($transaction_id,$user_id,$amount,$transction_type) {
        $checkPreviousCreditEntry = TransactionHistory::where(['transaction_id'=>$transaction_id,'transaction_type'=>'credit'])->first();
        if(is_null($checkPreviousCreditEntry) && $transction_type =='credit'):
	$closingAmount = getBalance($user_id) + $amount;
            TransactionHistory::create([
                'user_id'=>$user_id,
                'transaction_id'=>$transaction_id,
                'opening_balance'=>getBalance($user_id),
                'amount'=>$amount,
                'closing_balnce'=>$closingAmount,
                'transaction_type'=>$transction_type
            ]);
            Wallet::where('user_id',$user_id)->update([
                'amount'=>getBalance($user_id) + $amount
            ]);
        elseif ($transction_type =='debit'):
		$closingAmount  =getBalance($user_id) - $amount;
            TransactionHistory::create([
                'user_id'=>$user_id,
                'transaction_id'=>$transaction_id,
                'opening_balance'=>getBalance($user_id),
                'amount'=>$amount,
                'closing_balnce'=>$closingAmount,
                'transaction_type'=>$transction_type
            ]);
            Wallet::where('user_id',$user_id)->update([
                'amount'=>getBalance($user_id) - $amount ,
            ]);
        endif;
    }
endif;

if(!function_exists('getBalance')):
    function getBalance($user_id) {
        return Wallet::where('user_id',$user_id)->first()->amount;
    }
endif;

if(!function_exists('calculateGst')):
    function calculateGst($amount) {
        return   $amount*18/100;
    }
endif;

if(!function_exists('calculateCollectionCharges')):
    function calculateCollectionCharges($amount,$userId) {
        return  $amount*2/100;
    }
endif;

if(!function_exists('storeUserActivityLog')):
    function storeUserActivityLog($data =[]){
        UserActivityLog::create([
            'activity'=>$data['activity'],
            'ip_address'=>$data['ip_address'],
            'last_modify_id'=>$data['last_modify_id'],
            'changes'=>$data['changes'],
        ]);
    }
endif;

if(!function_exists('generateUniqueId')):
    function generateUniqueId($prefix = 'setl_') {
        $uuid = sprintf(
            '%04x%04x%04x%04x%04x%04x%04x%04x',
            random_int(0, 0xffff), random_int(0, 0xffff),
            random_int(0, 0xffff), random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000, random_int(0, 0xffff),
            random_int(0, 0xffff), random_int(0, 0xffff)
        );
        return $prefix . $uuid;
    }
endif;



