<?php

namespace App\Http\Helper\Payout;

use App\Models\FundRequest;
class QuintusPayoutPayment {

    private $prodCred ;

    public function __construct()
    {
        $this->prodCred = [
            'apiUrl'=>'',
            'partnerId'=>'',
            'consumersecret'=>'',
            'consumerkey'=>''
        ];
    }

    private function generateTransaction() {
        return uniqid();
    }

    public function makePayment($data) {

    }

    public function generateInstructionIdentification() {
        do {
            $instructionIdentification = 'GROSC'.rand(111111111111, 999999999999);
        } while (FundRequest::where("payout_id", $instructionIdentification)->first() instanceof FundRequest);

        return  $instructionIdentification;
    }

}

?>
