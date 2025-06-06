<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogManagerController extends Controller
{
    public function loginSession() {
        return view('admin.log-manager.login-session');
    }

    public function apiLogs() {
        return view('admin.log-manager.api-logs');
    }

    
    public function razorpayapiLogs() {
        return view('admin.log-manager.razorpay-api-logs');
    }
}
