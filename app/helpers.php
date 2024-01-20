<?php

use App\Models\ApiLog;
use App\Models\Commission;
use App\Models\OperatorManager;
use App\Models\Scheme;
use Illuminate\Support\Facades\Http;

if(!function_exists('apiCall')):
    function apiCall($headers,$url,$prameter,$log=false,$txn_id) {
        try {
            $response = Http::retry(3, 100)->withHeaders($headers)->post($url,$prameter);
            $res = $response->getBody()->getContents();
            if($log):
                ApiLog::create([
                    'url'=>$url,
                    'txn_id'=>$txn_id,
                    'header'=>json_encode($headers),
                    'request'=>json_encode($prameter),
                    'response'=> $res,
                ]);
            endif;
            return json_decode($res,true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }
endif;


if(!function_exists('getCommission')):
    function getCommission ($operaterType,$amount) {
        $charges = 0.00;
        $scheme = OperatorManager::where('operator_type',$operaterType)->where('charge_range_start','<=',$amount)->where('charge_range_end','>=',$amount)->where('status','1')->first();
        $commission = Commission::where(['slab_id'=>$scheme->id,'scheme_id'=>auth()->user()->apiPartner->scheme_id])->first();
        if($commission !=null):
            if($commission->type =='0'):
                $charges = $amount*$commission->value/100;
            else:
                $charges = $commission->value;
            endif;
        endif;
        return $charges;
    }
endif;