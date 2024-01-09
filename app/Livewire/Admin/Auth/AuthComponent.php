<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Traits\LoginSessionTraits;
use Carbon\Carbon;

class AuthComponent extends Component
{
    use LoginSessionTraits;
    public $username,$password,$lat,$long;
    public $listeners = [
        'latitude-longitude' => 'setLatitudeLongitude'
    ];

    protected $rules = [
        'username' => 'required|email',
        'password' => 'required',
    ];
    public function render()
    {
        return view('livewire.admin.auth.auth-component');
    }

    public function doLogin() {
        if(is_null($this->lat) && is_null($this->long)):
            session()->flash('error','Please allowed your location !');
            return false;
        else:
            $this->validate();
            if(Auth::attempt(['email' => $this->username, 'password' => $this->password])){
                $this->checkLastUserActivity($this->username);
                if(auth()->user()->status =='1'):
                    if($this->checkUserAlreadyLoggedIn() ==='0'):
                        auth()->logout();
                        session()->invalidate();
                        session()->regenerateToken();
                        session()->flash('error',"Already user logged in.");
                        return false;
                    endif;
                    $loginSessionData = [
                        'id'=>auth()->user()->id,
                        'latitude'=>$this->lat,
                        'logitude'=>$this->long,
                        'ip_address'=>request()->ip(),
                        'login_time'=>Carbon::now()->format('Y-m-d H:i:s'),
                        'is_logged_in'=>'0',
                    ];
                    $this->loginSessionStore($loginSessionData);
                    sleep(1);
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
        endif;
    }

    public function setLatitudeLongitude($latitude,$longitude) {
        // dd("Test");
        $this->lat = $latitude;
        $this->long = $longitude;
        // dd($latitude,$longitude);
    }


}
