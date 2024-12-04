<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\QRPaymentCollection;
use App\Models\Settelment;
use App\Models\SuccessfulPaymentCollection;

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
        $getCollections  = SuccessfulPaymentCollection::select('user_id', DB::raw('SUM(amount) as total_amount'),DB::raw('SUM(order_amount) as order_amount'),DB::raw('SUM(charges) as charges'),DB::raw('SUM(gst) as fees'))->whereDate('created_at',now()->format('Y-m-d'))->whereNull('settelment_id')->groupBy('user_id')->get();
        foreach($getCollections as $collection):
            $settelment=Settelment::create([
                'user_id'=>$collection->user_id,
                'settelment_id'=>generateUniqueId(),
                'amount'=>$collection->total_amount,
                'charges'=>$collection->charges,
                'gst'=>$collection->fees
            ]);
            // dd($settelment);
            SuccessfulPaymentCollection::whereDate('created_at',now()->format('Y-m-d'))->whereNull('settelment_id')->where('user_id',$collection->user_id)->update([
                'settelment_id'=>$settelment->settelment_id,
            ]);
            $getCurrentWalletAmount =  Wallet::where('user_id',$collection->user_id)->first()->amount;
            Wallet::where('user_id',$collection->user_id)->update([
                'amount'=>$collection->total_amount+$getCurrentWalletAmount
            ]);
            addTransactionHistory($settelment->settelment_id,$collection->user_id,$settelment->amount,'credit');
                       

        endforeach;
    }

}
