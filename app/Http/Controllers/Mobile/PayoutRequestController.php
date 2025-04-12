<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Fund;
use App\Models\FundRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MobileRequest\PayoutRequest;

class PayoutRequestController extends Controller
{

  public function payoutRequest()
    {
        $data = FundRequest::where('user_id', auth()->user()->id)->with('user','bank')->get();
        $result = [];
        if ($data->count() > 0) :
            foreach ($data as $fundRequest) {
                $result[] =
                [
                    'id' => $fundRequest->id,
                    'user_name' => $fundRequest->user->name,
                    'amount' => $fundRequest->amount,
                    'account_number' => $fundRequest->account_number,
                    'account_holder_name' => $fundRequest->account_holder_name,
                    'ifsc_code' => $fundRequest->ifsc_code,
                    'payment_mode_id' =>$fundRequest->payment_mode_id,
                ];
             }
        endif;
        return response()->json([
            'status' => true,
            'message' => 'Payout Request have been successfully.',
            'data' => $result,
        ], 200);
    }
}
