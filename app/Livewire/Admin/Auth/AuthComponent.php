<?php

namespace App\Livewire\Admin\Auth;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Traits\LoginSessionTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $user = User::where('email',$this->username)->first();
            $this->checkLastUserActivity($this->username);
            if(!$user || !Hash::check($this->password, $user->password??"")):
                $this->username='';
                $this->password='';
                session()->flash('error','Given Credentials invalid Please try again !');
                return false;
            endif;
            if($user->status =="0"):
                $this->username='';
                $this->password='';
                session()->invalidate();
                session()->regenerateToken();
                session()->flash('error',"You're account has been not approved, Please Contact a admin");
                return false;
            endif;
            // dd(getSettingValue('otp verification'));
            if((now()->diffInHours($user->verified_at) >=24 && getSettingValue('otp verification')=='yes') || ($user->verified_at ==null && getSettingValue('otp verification')=='yes')):
                if(now()->diffInMinutes($user->expire_at) >=120 || $user->verified_at ==null):
                    $otp = rand(1234, 9999);
                else:
                    $otp = $user->otp;
                endif;
                sendOtp($user->mobile_no,$otp);
                $user->update([
                    'otp'=>$otp,
                    'expire_at'=>now()->addMinutes(120)
                ]);
                return to_route('admin.otp.vrification')->with('mobile_no',str_repeat('*',6).substr($user->mobile_no,-4));
            else:
                if(Auth::attempt(['email' => $this->username, 'password' => $this->password])):
                    if(auth()->user()->status =='1'):
                        if(!$this->checkUserAlreadyLoggedIn()):
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
                else:
                    session()->flash('error','Given Credentials invalid Please try again !');
                    return false;
                endif;
            endif;

        endif;
    }

    public function setLatitudeLongitude($latitude,$longitude) {
        $this->lat = $latitude;
        $this->long = $longitude;
        session()->put('lat',$latitude);
        session()->put('long',$longitude);
    }




}
