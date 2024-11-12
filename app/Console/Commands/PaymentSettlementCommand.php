<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Wallet;
use Illuminate\Console\Command;
use App\Models\QRPaymentCollection;

class PaymentSettlementCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:payment-settlement-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A system process ensuring accurate, timely completion of financial transactions.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $getPaymentInSattelmnets = QRPaymentCollection::whereDate('created_at','<=',Carbon::now()->subDays(1)->format('Y-m-d'))->where(['status_id'=>'2','is_payment_settel'=>'0'])->get();
        foreach($getPaymentInSattelmnets as $getPaymentInSattelmnet):
            $collectionCharges = calculateCollectionCharges($getPaymentInSattelmnet->payment_amount,$getPaymentInSattelmnet->user_id);
            $collectionChargesGST = 0;
            if(in_array($getPaymentInSattelmnet->user_id,['10'])):
                $collectionChargesGST += calculateGst( $collectionCharges);
            endif;
            $chargesAndGstAmount =  $collectionCharges+  $collectionChargesGST;
            $amount = $getPaymentInSattelmnet->payment_amount-  $chargesAndGstAmount;
            addTransactionHistory($getPaymentInSattelmnet->qr_code_id,$getPaymentInSattelmnet->user_id,$amount,'credit');
            $getCurrentWalletAmount =  Wallet::where('user_id',$getPaymentInSattelmnet->user_id)->first()->amount;
            Wallet::where('user_id',$getPaymentInSattelmnet->user_id)->update([
                'amount'=>$getCurrentWalletAmount+$amount
            ]);
            $getPaymentInSattelmnet->update([
                'is_payment_settel'=>'1',
                'charge'=>$collectionCharges,
                'gst'=>$collectionChargesGST,
            ]);
        endforeach;
    }
}
