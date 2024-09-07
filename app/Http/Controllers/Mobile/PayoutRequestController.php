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

    public function createPayoutNewRequest(PayoutRequest $request) {
        $validator = Validator::make($request->all(), [
            'account_number' => 'required',
            'ifsc_code' => 'required',
            'account_holder_name' => 'required',
            'amount' => 'required',
            'payment_mode' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 401);
        }
        $userDetails = [
            'account_number'=> $request->account_number,
            'ifsc_code'=>$request->ifsc_code,
            'account_holder_name'=>$request->account_holder_name,
            'amount'=>$request->amount,
            'payment_mode'=>$request->payment_mode,
            'type'=>"mobile_api",
        ];
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
            ], 401);
        }
        else{
             return response()->json([
            'status' => true,
            'message' => 'Payout request created successfully.',
        ], 200);
        }
    }
}
