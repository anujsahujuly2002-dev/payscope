<?php

namespace App\Livewire\Admin\Member;

use App\Models\ApiPartner;
use Livewire\Component;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use App\Models\State;
use App\Models\Scheme;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ApiPartnerComponent extends Component
{
    use WithPagination;
    public $state=[];
    public $start_date;
    public $apiPartners;
    public $value;
    public $end_date;
    public function mount(){
        $this->apiPartners = User::whereHas('roles',function($q){
            $q->where('name','api-partner');
        })->when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->whereHas('apiPartner',function ($p){
                $p->where('added_by',auth()->user()->id);
            });
        })->get();
    }
    public function render()
    {
        if(!Auth::user()->can('api-partner-list')):
            throw UnauthorizedException::forPermissions(['api-partner-list']);
        endif;
        // dd($this->start_date);
        $states = State::orderBy('name','ASC')->get();
        $schemes = Scheme::where('user_id',auth()->user()->id)->get();

        return view('livewire.admin.member.api-partner-component',compact('states','schemes'));
    }

    // This Method Api Partner Create Method
    public function createApiPartner() {
        if(!Auth::user()->can('api-partner-create')):
            throw UnauthorizedException::forPermissions(['api-partner-create']);
        endif;
        $this->dispatch('show-form');
    }

    // This Method Api Partner Store
    public function StoreApiPartner() {
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
        ]);
        if($user):
            $apiPartner =ApiPartner::create([
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
                'website'=>$validateDate['website'],
            ]);
            $user->assignRole(['api-partner']);
            Wallet::create([
                'user_id'=>$user->id,
            ]);
            $this->dispatch('hide-form');
            if($apiPartner):
                sleep(1);
                return redirect()->back()->with('success','Api Partner Created Successfully !');
            else:
                DB::rollback();
                return redirect()->back()->with('error','Api Partner not created Please Try again !');
            endif;
        else:
            return redirect()->back()->with('error','Api Partner not created Please Try again !');
        endif;
    }

    public function statusUpdate($userId,$status){
        $statusUpdate = User::findOrFail($userId)->update([
            'status'=>$status ==1?0:1,
        ]);

        return redirect()->back()->with('success','Your Status has been updated');

    }
    public function search() {
        // dd($this->value);
       $this->apiPartners = User::whereHas('roles',function($q){
            $q->where('name','api-partner');
        })->when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->whereHas('apiPartner',function ($p){
                $p->where('added_by',auth()->user()->id)
                ->when($this->value !=null,function($d){
                    $d->where('mobile_no',$this->value);
                });
            });
        })
        ->when($this->value !=null,function($d){
            $d->whereHas('apiPartner',function ($p){
                    $p->where('mobile_no',$this->value);
                });
            })
        ->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);
        })->get();
        // dd($this->apiPartners );
    }


}
