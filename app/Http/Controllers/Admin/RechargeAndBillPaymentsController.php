<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RechargeAndBillPaymentsController extends Controller
{
    public function mobileRecharge() {
        return view('admin.recharge-and-bill-paymnets.mobile-recharge');
    }
}
