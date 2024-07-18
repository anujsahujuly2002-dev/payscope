<?php

namespace App\Http\Controllers\Mobile\Manual;

use App\Models\Bank;
use App\Models\Fund;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManualRequestController extends Controller
 {

public $banks;

    public function manualRequest(){
        $data = Fund::with(['users', 'bank'])->get();
        foreach ($data as $fund){

                $result[] = [
                    'id' => $fund->id,
                    'user_name'  => $fund->user->name,
                    'bank_name'  => $fund->bank->name,
                    'amount' => $fund->amount,
                    'account_number' =>$fund->bank->account_number,
                    'branch_name' => $fund->bank->branch_name,
                    'ifsc_code' => $fund->bank->ifsc_code,
                ];
            }
            return response()->json([
                'status' => true,
                'message' => 'Manual Funds have been successfully.',
                'data' => $result,
            ],200);
        }
    }
