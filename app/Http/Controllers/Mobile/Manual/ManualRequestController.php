<?php

namespace App\Http\Controllers\Mobile\Manual;

use App\Models\Bank;
use App\Models\Fund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ManualRequestController extends Controller
{
    public $banks;

    public function manualRequest()
    {
        $data = Fund::where('user_id', auth()->user()->id)->with(['user', 'bank','status'])->get();
        $result = [];
        if ($data->count() > 0) :
            foreach ($data as $fund) {
                $result[] = [
                    'id' => $fund->id,
                    'user_name' => $fund->user->name,
                    'bank_name' => $fund->bank->name,
                    'amount' => $fund->amount,
                    'account_number' => $fund->bank->account_number,
                    'branch_name' => $fund->bank->branch_name,
                    'ifsc_code' => $fund->bank->ifsc_code,
                    'status' => strip_tags($fund->status->name),
                ];
             }
        endif;
             return response()->json([
            'status' => true,
            'message' => 'Manual Funds have been successfully.',
            'data' => $result,
             ], 200);
    }

    public function createManualRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank' => 'required',
            'amount' => 'required',
            'payment_mode' => 'required',
            'pay_date' => 'required',
            'reference_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 401);
        }
        $userId = auth()->user()->id;
        if(auth()->user()->getRoleNames()->first()=='api-partner'):
            $creditedBy =  auth()->user()->apiPartner->added_by;
        else:
            $creditedBy =  auth()->user()->retailer->added_by;
        endif;
        $fund = Fund::create([
            'user_id' => $userId,
            'bank_id' => $request->bank,
            'payment_mode_id' => $request->payment_mode,
            'amount' => $request->amount,
            'type' => 'type',
            'credited_by' => $creditedBy,
            'pay_date' => $request->pay_date,
            'references_no' => $request->reference_number,
            'status_id' => 1,
        ]);
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Manual Funds created successfully.',
        //     'data' => $fund,
        // ], 200);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
            ], 401);
        }
        else{
             return response()->json([
            'status' => true,
            'message' => 'Manual Funds created successfully.',
            'data' => $fund,
        ], 200);
        }
    }
}
