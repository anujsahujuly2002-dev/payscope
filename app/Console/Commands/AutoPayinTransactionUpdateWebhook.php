<?php

namespace App\Console\Commands;

use Exception;
use Carbon\Carbon;
use App\Models\ApiToken;
use Illuminate\Console\Command;
use App\Models\QRPaymentCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\AutoPayinTransactionUpdate;

class AutoPayinTransactionUpdateWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-payin-transaction-update-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Webhook for auto-payment transaction updates in real-time processing.";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            $getPayInTransactions = QRPaymentCollection::where('id', '>', function ($query) {
                $query->from('auto_payin_transaction_updates')->selectRaw('COALESCE(MAX(qr_collection_id))');
            })->get();
            if($getPayInTransactions->count() >0):
                foreach ($getPayInTransactions as $transaction):
                    Log::error(json_encode($transaction));
                    if(in_array($transaction->status_id,[2,3,4])):
                        $webhookUrl = ApiToken::where('user_id', $transaction->user_id)->latest()->first();
                        if (!is_null($webhookUrl) && $webhookUrl->payin_webhook_url !== NULL) {
                            $parameters = [
                                "status" => true,
                                "msg" => "You're request has been complete",
                                "data" => [
                                   'qr_code_id'=>$transaction['qr_code_id'],
                                    'entity'=>$transaction['entity'],
                                    'name'=>$transaction['name'],
                                    'usage'=>$transaction['usage'],
                                    'type'=>$transaction['type'],
                                    'image_url'=>$transaction['image_url'],
                                    'payment_amount'=>$transaction['payment_amount'],
                                    'qr_status'=>$transaction['qr_status'],
                                    'description'=>$transaction['description'],
                                    'fixed_amount'=>$transaction['fixed_amount']?'1':'0',
                                    'payments_amount_received'=>$transaction['payments_amount_received'],
                                    'payments_count_received'=>$transaction['payments_count_received'],
                                    'qr_close_at'=>Carbon::parse($transaction['close_by'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                                    'qr_created_at'=>Carbon::parse($transaction['created_at'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                                    "rrn_no" => ucfirst(strip_tags($transaction->utr_number)),
                                    "payer_upi_id" => ucfirst(strip_tags($transaction->payer_name)),
                                    "payment_id" => ucfirst(strip_tags($transaction->payment_id)),
                                ],
                            ];
                            try{
                                Http::retry(3, 100)->post($webhookUrl->payin_webhook_url ,$parameters);
                                AutoPayinTransactionUpdate::create([
                                    'user_id'=>$transaction->user_id,
                                    'qr_collection_id'=>$transaction->id,
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
            endif;
           
        }catch(Exception $e) {
            Log::error([$e->getMessage()]);
        }
        

    }
}
