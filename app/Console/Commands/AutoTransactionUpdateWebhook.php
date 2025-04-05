<?php

namespace App\Console\Commands;

use Exception;
use App\Models\ApiToken;
use App\Models\AutoTransactionUpdateWebhookModel;
use App\Models\FundRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AutoTransactionUpdateWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-transaction-update-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The auto-transaction-update-webhook automatically sends real-time transaction status updates to a specified endpoint after processing, ensuring secure and timely communication with minimal manual intervention.sss';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $getTransactions = FundRequest::where('id', '>', function ($query) {
            $query->from('auto_transaction_update_webhook_models')->selectRaw('COALESCE(MAX(transaction_id), 4188)');
        })->get();
        foreach ($getTransactions as $transaction):
            if(in_array($transaction->status_id,[2,3,4])):
                $webhookUrl = ApiToken::where('user_id', $transaction->user_id)->latest()->first();
                if (!is_null($webhookUrl) && $webhookUrl->domain !== NULL) {
                    $parameters = [
                        "status" => true,
                        "msg" => "You're request has been complete",
                        "data" => [
                            "payout_ref" => $transaction->payout_ref,
                            "order_id" => $transaction->order_id,
                            "utr_number" => $transaction->utr_number,
                            "transaction_id" => $transaction->payout_id,
                            "status" => ucfirst(strip_tags($transaction->status->name)),
                            "account_number" => $transaction->account_number,
                            "account_holder_name" => $transaction->account_holder_name,
                            "ifsc_code" => $transaction->ifsc_code,
                            "amount" => $transaction->amount,
                            "charges" => $transaction->payoutTransactionHistories->charge,
                        ],
                    ];
                    try{
                        Http::retry(3, 100)->post($webhookUrl->domain ,$parameters);
                        AutoTransactionUpdateWebhookModel::create([
                            'user_id'=>$transaction->user_id,
                            'transaction_id'=>$transaction->id,
                            'webhook_url'=>$webhookUrl->domain
                        ]);
                    }catch(Exception $e) {
                        Log::error($e->getMessage());
                    }

                } else {
                    Log::info("Webhook Url Not a registerd");
                }

            endif;


        endforeach;
    }
}
