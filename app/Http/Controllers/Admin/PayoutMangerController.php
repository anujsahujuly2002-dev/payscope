<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayoutMangerController extends Controller
{
    public function payoutRequest () {
        return view('admin.payout.payout-request');
    }
}
