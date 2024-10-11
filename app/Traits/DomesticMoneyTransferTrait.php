<?php

namespace App\Traits;

use App\Models\User;

trait DomesticMoneyTransferTrait {

    protected function payerRegistrations ($data) {
        $url = "https://api.instantpay.in/fi/remit/out/domestic/remitterRegistration";
        $ip = request()->ip()=="::1"?"103.172.151.10":request()->ip();
        $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
        $user = User::find(auth()->user()->id);
        $pincode = $data['role']=='api-partner'?$user->apiPartner->pincode:$user->retailer->pincode;
        $name = explode(' ',$user->name);
        $requestParameter = [
            'mobile'=>$user->mobile_no,
            'firstName'=>$name[0],
            'lastName'=>array_key_exists(1,$name)?$name[1]:"",
            'pinCode'=>$pincode
        ];
 
        $headers = [
            'X-Ipay-Auth-Code'=>'1',
            'X-Ipay-Client-Id'=>'YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=',
            'X-Ipay-Client-Secret'=>'051093090b6671f1be11b91eed4091a220c37c51d321f064a25260f6a697114f',
            'X-Ipay-Endpoint-Ip'=>$ip,
            'Content-Type'=>'application/json',
            'X-Ipay-Outlet-Id'=>$user->outlet_id
        ];
        $res = apiCall($headers,$url,$requestParameter,true);
        if(isset($res['statuscode']) && in_array($res['statuscode'],['TXN','TUP','OTP'])):
            return [
                'status'=>true,
                'statuscode'=>$res['statuscode'],
                'msg'=>'Your'.$res['status'],
                'data'=>$res['data']
            ];
        elseif($res['actcode']=='BLOCKED'):
            return [
                'status'=>false,
                'msg'=>'Your '.$res['status'],
                // 'txn_id'=>$data['orderid']
            ]; 
        else:
            return [
                'status'=>false,
                'msg'=>'Your '.$res['status'],
                // 'txn_id'=>$data['orderid']
            ];
        endif;
    }

    protected function otpVerification($data) {
        $url = "https://api.instantpay.in/fi/remit/out/domestic/otpVerification";
        $ip = request()->ip()=="::1"?"103.172.151.10":request()->ip();
        $headers = [
            'X-Ipay-Auth-Code'=>'1',
            'X-Ipay-Client-Id'=>'YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=',
            'X-Ipay-Client-Secret'=>'051093090b6671f1be11b91eed4091a220c37c51d321f064a25260f6a697114f',
            'X-Ipay-Endpoint-Ip'=>$ip,
            'Content-Type'=>'application/json',
            'X-Ipay-Outlet-Id'=>auth()->user()->outlet_id
        ];
        $res = apiCall($headers,$url,$data,true);
        if(isset($res['statuscode']) && in_array($res['statuscode'],['TXN','TUP'])):
            return [
                'status'=>true,
                'msg'=>'Your'.$res['status'],
                'data'=>$res['data']
            ];
        else:
            return [
                'status'=>false,
                'msg'=>'Your '.$res['status'],
            ];
        endif;
    }
}