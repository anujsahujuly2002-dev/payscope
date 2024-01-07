<?php

namespace App\Traits;

use App\Models\LoginSession;

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
        dd(request()->session()->has('last_activity'));
    }
}