<?php

namespace App\Jobs;

use Exception;
use App\Models\ApiToken;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\AutoTransactionUpdateWebhookModel;

class FundRequestCallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    private $transaction;
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        $webhookUrl = ApiToken::where('user_id', $this->transaction ->user_id)->latest()->first();
        if (!is_null($webhookUrl) && $webhookUrl->domain !== NULL) {
            $parameters = [
                "status" => true,
                "msg" => "You're request has been complete",
                "data" => [
                    "payout_ref" => $this->transaction ->payout_ref,
                    "order_id" => $this->transaction ->order_id,
                    "utr_number" => $this->transaction ->utr_number,
                    "transaction_id" => $this->transaction ->payout_id,
                    "status" => ucfirst(strip_tags($this->transaction ->status->name)),
                    "account_number" => $this->transaction ->account_number,
                    "account_holder_name" => $this->transaction ->account_holder_name,
                    "ifsc_code" => $this->transaction ->ifsc_code,
                    "amount" => $this->transaction->amount,
                    "charges" => $this->transaction->payoutTransactionHistories->charge,
                ],
            ];
            try{
                Http::retry(3, 100)->post($webhookUrl->domain ,$parameters);
                AutoTransactionUpdateWebhookModel::create([
                    'user_id'=>$this->transaction ->user_id,
                    'transaction_id'=>$this->transaction ->id,
                    'webhook_url'=>$webhookUrl->domain 
                ]);
            }catch(Exception $e) {
                Log::error($e->getMessage());
            }
   
        } else {
            Log::info("Webhook Url Not a registerd");
        }
    }
}
