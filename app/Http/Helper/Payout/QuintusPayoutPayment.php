<?php

namespace App\Http\Helper\Payout;

use App\Models\FundRequest;
use Illuminate\Support\Facades\Log;

class QuintusPayoutPayment {

    private $prodCred,$url="https://prod.quintustech.in/api/payout/domesticPayments",$data ;

    public function __construct()
    {
        $this->prodCred = [
            'apiUrl'=>'',
            'partnerId'=>'',
            'consumersecret'=>'',
            'consumerkey'=>''
        ];
    }

    

    public function makePayment($data) {
        $headers = [
            "partnerId"=>"119946",
            "consumersecret"=>"e1a2e6054ae3f87c",
            "consumerkey"=>"c8b99c6c7c26e339"
        ];

        $payload = [
            "reqId"=> $data['reqId'],
            "name"=>'YPAY',
            "sub_service_name"=>"IMPS",
            "amount"=>$data['amount'],
            "creditorAccountNo"=>$data['account_number'],
            "creditorIFSC"=>$data['ifsc_code'],
            "creditorName"=>$data['account_holder_name'],
            "instructionIdentification"=>$data['payoutid'],
            "creditorEmail"=>$data['creditor_email'],
            "creditorMobile"=>$data['creditor_mobile'],
            "paymentType"=>"IMPS",
        ];

      
        $response = apiCall($headers,$this->url,$payload,true,$payload['instructionIdentification']);
        if($response['success']):
            if(array_key_exists('data',$response)):
                $fundRequest=Fundrequest::where(['payout_id'=>$response['data']['remark']])->first();
                Fundrequest::where('id',$fundRequest->id)->update([
                    'payout_ref'=>$response['data']['quintus_transaction_id'],
                    'quintus_transaction_id'=>$response['data']['referenceNo']
                ]);
            endif;
        endif;
        return json_encode($response);
    }

    // public function generateInstructionIdentification() {
    //     do {
    //         $instructionIdentification = 'GROSC'.rand(111111111111, 999999999999);
    //     } while (FundRequest::where("payout_id", $instructionIdentification)->first() instanceof FundRequest);

    //     return  $instructionIdentification;
    // }

}

?>
