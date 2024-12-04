<?php

namespace App\Console\Commands;

use Razorpay\Api\Api;
use Illuminate\Console\Command;
use App\Models\Dispute;
use App\Models\QRPaymentCollection;

class GetDisputePaymentInRazorPayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-dispute-payment-in-razor-pay-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    protected $api;
    public function handle()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $disputes = $this->api->dispute->all()->items;
        // dd($disputes);
        foreach($disputes as $dispute):
            $disputecheck = Dispute::where('dispute_id',$dispute->id)->get();
            if($disputecheck->count() >0):
                $getPaymentDetails = QRPaymentCollection::where('payment_id',$dispute->payment_id)->first();
                Dispute::create([
                    'dispute_id'=>$dispute->id,
                ]);
            endif;
        endforeach;
    }
}
