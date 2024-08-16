<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Bank;
use App\Models\Status;
use App\Models\PaymentMode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function paymentModeList()
    {
        $paymentModes = PaymentMode::all();
        return response()->json($paymentModes, 200);
    }

    public function bankList()
    {
        $banks = Bank::all();
        return response()->json($banks, 200);
    }

    public function statusList()
    {
        $statuses = Status::all();
        return response()->json($statuses, 200);
    }
}

