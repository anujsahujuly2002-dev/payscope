<?php

namespace App\Livewire\Admin\Member;

use App\Models\User;
use App\Models\State;
use Livewire\Component;
use App\Models\ApiPartner;
use App\Models\Retailer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileComponet extends Component
{
    public $state = [];
    public $id;
    public $user;
    public $password=[];
    public $tab = null;
    public function mount() {
        $this->user  = User::with('roles')->where('id',base64_decode(request()->id))->first();
        $this->state  = User::with('roles')->where('id',base64_decode(request()->id))->first()->toArray();
        $this->id =   $this->state['id'];
    }
    public function render()
    {
        $states = State::orderBy('name','ASC')->get();
        return view('livewire.admin.member.profile-componet',compact('states'));
    }

    public function updatePersonalInformation() {
        // dd($this->state['id']);
        $validateData = Validator::make($this->state,[
            'name'=>'required|min:3|string',
            'email'=>'required|email|unique:users,email,'.$this->id,
            'mobile_no'=>'required|numeric|digits:10|unique:users,mobile_no,'.$this->id,
            'address'=>'required',
            'state_name'=>'required',
            'city'=>'required|string',
            'pincode'=>'required|numeric|min_digits:6|digits:6',
        ])->validate();
        $user =$this->user->update([
            'name'=>$validateData['name'],
            'email'=>$validateData['email'],
            'mobile_no'=>$validateData['mobile_no'],
        ]);
        if($user):
            if(auth()->user()->getRoleNames()->first()=='api-partner'):
                ApiPartner::where('user_id',$this->id)->update([
                    'mobile_no'=>$validateData['mobile_no'],
                    'state_id'=>$validateData['state_name'],
                    'city'=>$validateData['city'],
                    'pincode'=>$validateData['pincode'],
                    'address'=>$validateData['address'],
                ]);
            else:
                Retailer::where('user_id',$this->id)->update([
                    'mobile_no'=>$validateData['mobile_no'],
                    'state_id'=>$validateData['state_name'],
                    'city'=>$validateData['city'],
                    'pincode'=>$validateData['pincode'],
                    'address'=>$validateData['address'],
                ]);
            endif;
           
            sleep(1);
            return redirect()->back()->with('success',"You're personal information update successfully !");
        else:
            return redirect()->back()->with('error',"You're personal information not update,Please try again !");
        endif;
    }

    public function changePassword(){
        $this->tab ="password manager";
        $validateData = Validator::make($this->password,[
           'old_password'=>'required',
           'new_password'=>'required|min:8',
           'confirm_password'=>'required_with:new_password|same:new_password|min:8',
        ])->validate();
        if($validateData['old_password'] !=null):
            if (!Hash::check($validateData['old_password'], $this->user->password)) { 
                return redirect()->back()->with('error',"You're old password does'nt match");
            }
        endif;
        $changePassword =$this->user->update([
            'password'=>Hash::make($validateData['confirm_password']),
        ]);
        if($changePassword):
            auth()->logout();
            sleep(1);
            return redirect()->route('admin.login')->with('success',"You're passaword has been changed, Please login now !");
        else:
            sleep(1);
            return redirect()->back()->with('error',"You're password does not change, Please try again..");
        endif;
    }
}
