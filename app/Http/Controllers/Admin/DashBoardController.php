<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Wallet;
use App\Models\LoginSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }
    public function logout (Request $request) {
        $user = auth()->user()->id;
        LoginSession::where(['user_id'=>$user,'is_logged_in'=>'0'])->update([
            'is_logged_in' => '1',
            'logout_time'=>Carbon::now()->format('Y-m-d H:i:s')
        ]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('admin.login')->with('success','Your account has been logout');
    }

    public function settelment() {
        return view('admin.settelment');
    }


    public function ekoPayoutWebHook(Request $request) {
        Log::info('Request data:', $request->all());
    }

    public function getDisputePayment(Request $request) {
        Log::info('Request data:', $request->all());
    }
}
