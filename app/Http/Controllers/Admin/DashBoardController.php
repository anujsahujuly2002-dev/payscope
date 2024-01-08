<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginSession;
use Carbon\Carbon;

class DashBoardController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }
    public function logout (Request $request) {
        $user = auth()->user()->id;
        LoginSession::where('user_id',$user)->update([
            'is_logged_in' => '1',
            'logout_time'=>Carbon::now()->format('Y-m-d H:i:s')
        ]);
        Auth::logout();    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('admin.login')->with('success','Your account has been logout');
    }
}
