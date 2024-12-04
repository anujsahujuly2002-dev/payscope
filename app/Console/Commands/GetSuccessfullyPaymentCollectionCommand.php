<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\QRPaymentCollection;
use App\Models\SuccessfulPaymentCollection;

class GetSuccessfullyPaymentCollectionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-successfully-payment-collection-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $getSuccessfullyPaymentCollections  = QRPaymentCollection::whereDate('qr_close_at','<=',Carbon::now()->subDays(1)->format('Y-m-d'))->where(['status_id'=>'2','is_payment_settel'=>'0'])->get();
        foreach($getSuccessfullyPaymentCollections as $getSuccessfullyPaymentCollection):
            SuccessfulPaymentCollection::create([
                'user_id'=>$getSuccessfullyPaymentCollection->user_id,
                'payment_id'=>$getSuccessfullyPaymentCollection->payment_id,
                'order_amount'=>$getSuccessfullyPaymentCollection->payment_amount,
                'amount'=>$getSuccessfullyPaymentCollection->payment_amount-getCommission("payin",$getSuccessfullyPaymentCollection->payment_amount,$getSuccessfullyPaymentCollection->user_id)['payout_charges'],
                'charges'=>getCommission("payin",$getSuccessfullyPaymentCollection->payment_amount,$getSuccessfullyPaymentCollection->user_id)['payout_charges'],
               'gst'=>getCommission("payin",$getSuccessfullyPaymentCollection->payment_amount,$getSuccessfullyPaymentCollection->user_id)['gst_charge'],
            ]);
            $getSuccessfullyPaymentCollection->update([
                'is_payment_settel'=>'1',
                'charge'=>getCommission("payin",$getSuccessfullyPaymentCollection->payment_amount,$getSuccessfullyPaymentCollection->user_id)['payout_charges'],
                'gst'=>getCommission("payin",$getSuccessfullyPaymentCollection->payment_amount,$getSuccessfullyPaymentCollection->user_id)['gst_charge'],
            ]);
        endforeach;
    }
}
