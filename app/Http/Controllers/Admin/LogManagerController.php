<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogManagerController extends Controller
{
    public function loginSession() {
        return view('admin.log-manager.login-session');
    }
}
