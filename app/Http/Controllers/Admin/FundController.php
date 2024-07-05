<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FundController extends Controller
{
    public function manualRequest() {
        return view('admin.fund-manager.manual-request');
    }

    public function virtualRequest () {
        return view('admin.fund-manager.virtual-request');
    }

}
