<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Razorpay\Api\Api;
use App\Models\Wallet;
use App\Models\Dispute;
use Illuminate\Console\Command;
use App\Models\QRPaymentCollection;
use Illuminate\Support\Facades\Http;

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
        $skip = 0;
        $count = 1; // Adjust as per Razorpay's maximum limit for `count`

        do {
            $response = Http::withBasicAuth(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'))->get("https://api.razorpay.com/v1/disputes?skip={$skip}&count={$count}");
            $disputes = $response->json('items'); // Assuming the disputes are under 'items'
            foreach ($disputes as $dispute) {
                $disputecheck = Dispute::where('dispute_id', $dispute['id'])->get();
                print_r($dispute);
                if ($disputecheck->isEmpty()) {
                    $getPaymentDetails = QRPaymentCollection::where('payment_id', $dispute['payment_id'])->first();
                    if(!is_null($getPaymentDetails)):
                        Dispute::create([
                            'user_id'=>$getPaymentDetails->user_id,
                            'dispute_id' => $dispute['id'],
                            'payment_id'=>$dispute['payment_id'],
                            'entity' => $dispute['entity'],
                            'amount' => $dispute['amount']/100,
                            'currency' => $dispute['currency'],
                            'amount_deducted' => $dispute['amount_deducted']/100,
                            'gateway_dispute_id' => $dispute['gateway_dispute_id'], 
                            'reason_code' => ucwords(str_replace('_',' ',$dispute['reason_code'])),
                            'respond_by' =>  Carbon::parse($dispute['respond_by'])->format('Y-m-d H:i:s'),
                            'status' => $dispute['status'],
                            'phase' => $dispute['phase'],
                            'comments' => $dispute['comments'],
                            'created_at_razorpay' => Carbon::parse($dispute['created_at'])->format('Y-m-d H:i:s'),
                        ]);
                        $getCurentLockedAmount = Wallet::where('user_id',$getPaymentDetails->user_id)->first();
                        $getCurentLockedAmount->update([
                            'locked_amuont'=>$getCurentLockedAmount->locked_amuont+$dispute['amount_deducted']/100
                        ]);
                    endif;
                }
            }
            $skip += $count; // Move to the next set of records
        } while (count($disputes) === $count);
    }
}
