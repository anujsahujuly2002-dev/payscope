<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AuthComponent extends Component
{
    public $username,$password;
    protected $rules = [
        'username' => 'required|email',
        'password' => 'required',
    ];
    public function render()
    {
        return view('livewire.admin.auth.auth-component');
    }

    public function doLogin() {
        $this->validate();
        if(Auth::attempt(['email' => $this->username, 'password' => $this->password])){
            if(auth()->user()->status =='1'):
                sleep(3);
                return to_route('admin.dashboard');
            else:
                auth()->logout();
                session()->invalidate();
                session()->regenerateToken();
                session()->flash('error',"You're account has been not approved, Please Contact a admin");
                return false;
            endif;
           
        }else{
            session()->flash('error','Given Credentials invalid Please try again !');
            return false;
        }
    }


}
