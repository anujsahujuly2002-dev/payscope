<?php

namespace App\Http\Controllers\Mobile;
use App\Models\VirtualRequest;
use App\Http\Controllers\Controller;

class VirtualRequestController extends Controller
{

    public function virtualRequest()
    {
        $data = VirtualRequest::where('user_id', auth()->user()->id)->get();
        // $data = VirtualRequest::all();
        $result = [];
        if ($data->count() > 0) :
            foreach ($data as $virtual) {
                $result[] = [
                    'id' => $virtual->id,
                    'credit_time' => $virtual->credit_time,
                    'remitter_name' => $virtual->remitter_name,
                    'order_amount' => $virtual->credit_amount,
                    'remitter_account_number' => $virtual->remitter_account_number,
                    'reference_number' => $virtual->reference_number,
                    'remitter_ifsc_code' => $virtual->remitter_ifsc_code,
                    'remitter_utr' => $virtual->remitter_utr,
                ];
            }
            endif;

        return response()->json([
            'status' => true,
            'message' => 'Virtual Funds have been successfully.',
            'data' => $result,

        ]);
    }

}

