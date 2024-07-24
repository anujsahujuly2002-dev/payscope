<?php

namespace App\Http\Controllers\Mobile\Manual;

use App\Models\Bank;
use App\Models\Fund;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ManualRequestController extends Controller
{
    public $banks;

    public function manualRequest()
    {
        $data = Fund::where('user_id', auth()->user()->id)->with(['user', 'bank'])->get();
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
        $validateData = Validator::make($request->all(), [
            'bank' => 'required',
            'amount' => 'required|numeric|min:100',
            'payment_mode' => 'required',
            'pay_date' => 'required',
            'reference_number' => 'required|unique:funds,references_no'
        ])->validate();


        $funds = Fund::create([
            'user_id' => auth()->user()->id,
            'bank_id' => $request->bank,
            'payment_mode_id' => $request->payment_mode,
            'amount' => $request->amount,
            'type' => 'type',
            'pay_date' => $request->pay_date,
            'references_no' => $request->reference_number,
            'status_id' => 1,
        ]);

        return response()->json([
            'status' => false,
            'message' => 'error',
            'data' => $validateData,
        ],401);


        return response()->json([
            'status' => true,
            'message' => 'Manual Funds created successfully.',
            'data' => $funds,
        ], 200);
    }
}
