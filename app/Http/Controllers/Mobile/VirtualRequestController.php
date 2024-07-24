<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Fund;
use App\Models\Status;
use Illuminate\Http\Request;
// use App\Models\VirtualRequest;
use App\Models\VirtualRequest;
use App\Http\Controllers\Controller;

class VirtualRequestController extends Controller
{

    public function virtualRequest()
    {
        $virtualRequest = VirtualRequest::where('user_id', auth()->user()->id)->with(['user', 'bank','fund'])->get();
        $result = [];
        if ($virtualRequest->count() > 0) :
            foreach ($virtualRequest as $virtual) {
                $result[] = [
                    'id' => $virtual->id,
                    'credit_time' => $virtual->credit_time,
                    'remitter_name' => $virtual->remitter_name,
                    'order_amount' => $virtual->bank->credit_amount,
                    'remitter_account_number' => $virtual->bank->remitter_account_number,
                    'reference_number' => $virtual->bank->reference_number,
                    'remitter_ifsc_code' => $virtual->bank->remitter_ifsc_code,
                    'remitter_utr' => $virtual->bank->remitter_utr,
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

