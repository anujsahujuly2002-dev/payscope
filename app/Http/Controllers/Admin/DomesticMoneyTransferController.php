<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DomesticMoneyTransferController extends Controller
{
    public function index() {
        return view('admin.domestic-money-transfer.recipient-list');
    }
}
