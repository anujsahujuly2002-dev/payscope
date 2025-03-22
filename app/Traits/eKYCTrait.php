<?php
namespace App\Traits;
use Carbon\Carbon;
use App\Models\User;


trait eKYCTrait { 
    protected function signUpEkycInitiate($data = []) {
        $url = "https://api.instantpay.in/user/outlet/signup/initiate";
        $ip = request()->ip()=="::1"?"103.172.151.10":request()->ip();
        $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
        $user = User::find($data['agent_id']);
        $requestParameter = [
           'mobile'=>$user->mobile_no,
           'email'=>$user->email,
           'aadhaar'=>$this->generateEncryptionKey($data['adhaarcard_number']),
           'pan'=>$data['pancard_number'],
           'bankAccountNo'=>$data['account_number'],
           'bankIfsc'=>$data['ifsc_code'],
           "latitude"  => $new_arr[0]['geoplugin_latitude'],
           "longitude"=> $new_arr[0]['geoplugin_longitude'],
           'consent'=>"Y",
        ];

        $headers = [
            'X-Ipay-Auth-Code'=>'1',
            'X-Ipay-Client-Id'=>'YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=',
            'X-Ipay-Client-Secret'=>'051093090b6671f1be11b91eed4091a220c37c51d321f064a25260f6a697114f',
            'X-Ipay-Endpoint-Ip'=>$ip,
            'Content-Type'=>'application/json'
        ];
        $res = apiCall($headers,$url,$requestParameter,true);
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
                // 'txn_id'=>$data['orderid']
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

    protected function signUpEkycInitiateValidate($data) {
        $url = "https://api.instantpay.in/user/outlet/signup/validate";
        $ip = request()->ip()=="::1"?"103.172.151.10":request()->ip();
        $headers = [
            'X-Ipay-Auth-Code'=>'1',
            'X-Ipay-Client-Id'=>'YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=',
            'X-Ipay-Client-Secret'=>'051093090b6671f1be11b91eed4091a220c37c51d321f064a25260f6a697114f',
            'X-Ipay-Endpoint-Ip'=>$ip,
            'Content-Type'=>'application/json'
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