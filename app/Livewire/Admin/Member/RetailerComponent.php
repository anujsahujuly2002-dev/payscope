<?php

namespace App\Livewire\Admin\Member;

use App\Models\User;
use App\Models\State;
use App\Models\Scheme;
use App\Models\Wallet;
use Livewire\Component;
use App\Models\Retailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RetailerComponent extends Component
{
    use WithPagination;
    public $state = [];
    public function render()
    {
        if(!auth()->user()->can('retailer-list'))
        throw UnauthorizedException::forPermissions(['retailer-list']);
        $states = State::orderBy('name','ASC')->get();
        $schemes = Scheme::where('user_id',auth()->user()->id)->get();
        $retailers = User::whereHas('roles',function($q){
            $q->where('name','retailer');
        })->when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->whereHas('apiPartner',function ($p){
                $p->where('added_by',auth()->user()->id);
            });
        })->latest()->paginate(10);
        return view('livewire.admin.member.retailer-component',compact('states','schemes','retailers'));
    }

    public function create() {
        if(!auth()->user()->can('retailer-create'))
        throw UnauthorizedException::forPermissions(['retailer-create']);
        $this->reset();
        $this->dispatch('show-form');
    }

    public function store() {
        $validateDate = Validator::make($this->state,[
            'name'=>'required|string|min:3',
            'email'=>'required|email|unique:users,email',
            'mobile_number'=>'required|numeric|digits:10',
            'address'=>'required',
            'state_name'=>'required',
            'city'=>'required|string',
            'pincode'=>'required|numeric|min_digits:6|digits:6',
            'shop_name'=>'required|string|min:3',
            'pancard_number'=>'required|string',
            'adhaarcard_number'=>'required|numeric|min_digits:12|digits:12',
            'scheme'=>'required',
            // 'website'=>'required|url:https'
        ])->validate();
        $user = User::create([
            'name'=>$validateDate['name'],
            'email'=>$validateDate['email'],
            'password'=>Hash::make($validateDate['mobile_number']),
            'mobile_no'=>$validateDate['mobile_number'],
        ]);
        if($user):
            $apiPartner =Retailer::create([
                'user_id'=>$user->id,
                'added_by'=>auth()->user()->id,
                'mobile_no'=>$validateDate['mobile_number'],
                'address'=>$validateDate['address'],
                'state_id'=>$validateDate['state_name'],
                'city'=>$validateDate['city'],
                'pincode'=>$validateDate['pincode'],
                'shop_name'=>$validateDate['shop_name'],
                'pancard_no'=>$validateDate['pancard_number'],
                'addhar_card'=>$validateDate['adhaarcard_number'],
                'scheme_id'=>$validateDate['scheme'],
                'website'=>$validateDate['website']??NULL,
            ]);
            $user->assignRole(['retailer']);
            Wallet::create([
                'user_id'=>$user->id,
            ]);
            $this->dispatch('hide-form');
            if($apiPartner):
                sleep(1);
                return redirect()->back()->with('success','Retailer Created Successfully !');
            else:
                DB::rollback();
                return redirect()->back()->with('error','Retailer not created Please Try again !');
            endif;
        else:
            return redirect()->back()->with('error','Retailer not created Please Try again !');
        endif;
    }

    public function statusUpdate($userId,$status){
        $statusUpdate = User::findOrFail($userId)->update([
            'status'=>$status==0?1:0,
        ]);
        return redirect()->back()->with('success','Your Status has been updated');
    }
}
