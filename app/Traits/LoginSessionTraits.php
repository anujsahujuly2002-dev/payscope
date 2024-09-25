<?php

namespace App\Traits;

use App\Models\LoginSession;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait LoginSessionTraits {
    
    protected function loginSessionStore($data = array()) {
        LoginSession::create([
            'user_id'=>$data['id'],
            'latitude'=>$data['latitude'],
            'logitude'=>$data['logitude'],
            'ip_address'=>$data['ip_address'],
            'login_time'=>$data['login_time'],
            'is_logged_in'=>$data['is_logged_in'],
        ]);
    }

    protected function checkUserAlreadyLoggedIn(){
        $checkUserAlreadyLoggedIn = LoginSession::where(['user_id'=>auth()->user()->id,'is_logged_in'=>'0'])->get();
        if($checkUserAlreadyLoggedIn->count() ==4):
            return false;
        else:
            return true;
        endif;
        // dd($checkUserAlreadyLoggedIn);
        // return $checkUserAlreadyLoggedIn->is_logged_in ??"1";
    }


    protected function checkLastUserActivity($email){
        $userId = User::where('email',$email)->first()->id;
        $lastActivity = DB::table('sessions')->where('user_id',$userId)->first();
        if(!is_null($lastActivity)):
            $lastActivityTime = Carbon::parse($lastActivity->last_activity);
            if(now()->diffInMinutes($lastActivityTime) >= (config('session.lifetime') - 1)):
                LoginSession::where(['user_id'=>$userId,'is_logged_in'=>'0'])->update([
                    'is_logged_in' => '1',
                    'logout_time'=>Carbon::now()->format('Y-m-d H:i:s')
                ]);
                DB::table('sessions')->where('user_id',$userId)->update([
                    'user_id'=>NULL,
                ]);
            endif;
        elseif(is_null($lastActivity)):
            LoginSession::where(['user_id'=>$userId,'is_logged_in'=>'0'])->update([
                'is_logged_in' => '1',
                'logout_time'=>Carbon::now()->format('Y-m-d H:i:s')
            ]);
        endif;
    }
}
