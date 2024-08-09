<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Fund;
use App\Models\FundRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PayoutRequestController extends Controller
{



    public function payoutRequest()
    {
        $data = FundRequest::where('user_id', auth()->user()->id)->with(['user', 'bank'])->get();
        $result = [];
        if ($data->count() > 0) :
            foreach ($data as $fundRequest) {
                $result[] =
                [
                    'id' => $fundRequest->id,
                    'user_name' => $fundRequest->user->name,
                    'bank_name' => $fundRequest->bank->name,
                    'amount' => $fundRequest->amount,
                    'account_number' => $fundRequest->bank->account_number,
                    'account_holder_name' => $fundRequest->bank->account_holder_name,
                    'branch_name' => $fundRequest->bank->branch_name,
                    'ifsc_code' => $fundRequest->bank->ifsc_code,
                    'payment_mode_id' =>$fundRequest->payment_mode,
                    'remark' => 'remark'
                ];
             }
        endif;
             return response()->json([
            'status' => true,
            'message' => 'Payout Request have been successfully.',
            'data' => $result,
             ], 200);
    }

    public function createPayoutNewRequest(Request $request)
     {
        $validator = Validator::make($request->all(),[
            'account_number'=>'required|numeric|min:5',
            'ifsc_code' =>'required',
            'account_holder_name'=>'required',
            'amount'=>'required',
            'payment_mode'=>'required',
            'bank_name'=>'required',
            'remark'=>'required',
        ]);
        // $validateData['user_id']= auth()->user()->id;
        // // $response = $this->payoutApiRequest($validateData);
        // $response = $this->ekoPayoutApi($validateData);;
        // $this->dispatch('hide-form');
        // if($response['status']=='0005'):
        //     return redirect()->back()->with('success',$response['msg']);
        // else:
        //     return redirect()->back()->with('error',$response['msg']);
        // endif;

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 401);
        }else{
            return response()->json([
           'status' => true,
           'message' => 'Payout created successfully.',
       ], 200);
       }
     }
}
