<?php

namespace App\Traits;

use App\Models\User;

trait DomesticMoneyTransferTrait {

    protected function payerRegistrations ($data) {
        $user = User::find(auth()->user()->id);
        $remitterProfileResponse =$this->remitterProfile($user->mobile_no);
        if($remitterProfileResponse['status'] && !isset($remitterProfileResponse['statuscode'])):
            return [
                'status'=>true,
                'data'=>$remitterProfileResponse['data']
            ];
        elseif (!$remitterProfileResponse['status'] && isset($remitterProfileResponse['statuscode']) && $remitterProfileResponse['statuscode']=='ERR'):
            return [
                'status'=>false,
                'statuscode'=>$remitterProfileResponse['statuscode'],
                'message'=>$remitterProfileResponse['message']
            ];
        else:
            $url = "https://api.instantpay.in/fi/remit/out/domestic/v2/remitterRegistration";
            $ip = request()->ip()=="::1"?"103.172.151.10":"65.0.180.154";
            $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
            $requestParameter = [
                'mobileNumber'=>$user->mobile_no,
                'encryptedAadhaar'=>$this->generateEncryptionKey($data['role']=='api-partner'?$user->apiPartner->addhar_card:$user->retailer->addhar_card),
                'referenceKey'=>$remitterProfileResponse['referenceKey']
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
            if(isset($res['statuscode']) && in_array($res['statuscode'],['OTP'])):
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
        endif;
        
    }

    protected function otpVerification($data) {
        $url = "https://api.instantpay.in/fi/remit/out/domestic/v2/remitterRegistrationVerify";
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
        dd($res);
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

    private function generateEncryptionKey($aadhar){
        $aadhaarNumber=$aadhar;
        $encryptionKey='77723914a980660277723914a9806602';
        $ivlen = openssl_cipher_iv_length('aes-256-cbc');
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($aadhaarNumber,'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);
        $encryptedData = base64_encode($iv . $ciphertext);
		return $encryptedData;
    }



    private function remitterProfile($mobileNo) {
        $url = "https://api.instantpay.in/fi/remit/out/domestic/v2/remitterProfile";
        $ip = request()->ip()=="::1"?"103.172.151.10":request()->ip();
        $headers = [
            'X-Ipay-Auth-Code'=>'1',
            'X-Ipay-Client-Id'=>'YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=',
            'X-Ipay-Client-Secret'=>'051093090b6671f1be11b91eed4091a220c37c51d321f064a25260f6a697114f',
            'X-Ipay-Endpoint-Ip'=>$ip,
            'Content-Type'=>'application/json',
            'X-Ipay-Outlet-Id'=>auth()->user()->outlet_id
        ];
        $data = [
            'mobileNumber'=>$mobileNo
        ];
        $res = apiCall($headers,$url,$data,true);
        if(isset($res['statuscode']) && $res['statuscode']==='RNF'):
            return [
                'status'=>false,
                'referenceKey'=>$res['data']['referenceKey'],
                'validity'=>$res['data']['validity'],
            ];
        elseif(isset($res['statuscode']) && $res['statuscode']==='TXN'):
            return [
                'status'=>true,
                'data'=>$res['data'],
            ];
        elseif(isset($res['statuscode']) && $res['statuscode']==='ERR'):
            return [
                'status'=>false,
                'statuscode'=>$res['statuscode'],
                'message'=>$res['status'],
            ];
        endif;
    }
}