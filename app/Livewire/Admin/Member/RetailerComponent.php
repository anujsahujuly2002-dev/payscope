<?php

namespace App\Livewire\Admin\Member;

use App\Models\User;
use App\Models\State;
use App\Models\Scheme;
use App\Models\Wallet;
use Livewire\Component;
use App\Models\Retailer;
use Livewire\WithPagination;
use App\Exports\RetailerExport;
use App\Exports\ApiPartnerExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Traits\eKYCTrait;

class RetailerComponent extends Component
{
    use WithPagination,eKYCTrait;
    public $state=[];
    public $start_date;
    public $value;
    public $end_date;
    public $createRetailerForm  = false;
    public $assignPermissionUserBasedForm = false;
    public $schemeForm = false;
    public $retailerId;
    public $scheme;
    public $permission=[];
    public $permissionsId=[];
    public $user;
    public $agentId;
    public $ekyApiPartnerId;
    public $otpReferenceID;
    public $hash;
    public $ekycForm = false;
    public $otp= false;
    public $ekycFormData=[];
    public $otp_code;
    protected $rules = [
        'otp_code' => 'required|integer',
    ];


    public function render()
    {
        if(!auth()->user()->can('retailer-list'))
        throw UnauthorizedException::forPermissions(['retailer-list']);
        $states = State::orderBy('name','ASC')->get();
        $schemes = Scheme::where('user_id',auth()->user()->id)->get();
        $retailers = User::whereHas('roles',function($q){
            $q->where('name','retailer');
        })->when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->whereHas('retailer',function ($p){
                $p->where('added_by',auth()->user()->id);
            });
        })->when(auth()->user()->getRoleNames()->first()=='retailer',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })
        ->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);
        })
        ->when($this->agentId !=null,function($u){
            $u->where('id',$this->agentId);
        })
        ->when($this->value !=null,function($u){
            $u->where('mobile_no',$this->value);
        })->latest()->paginate(10);
        return view('livewire.admin.member.retailer-component',compact('states','schemes','retailers'));
    }

    public function create() {
        if(!auth()->user()->can('retailer-create'))
        throw UnauthorizedException::forPermissions(['retailer-create']);
        $this->reset();
        $this->createRetailerForm = true;
        $this->assignPermissionUserBasedForm = false;
        $this->schemeForm=false;
        $this->dispatch('show-form');
    }

    public function store() {
        $validateData = Validator::make($this->state,[
            'name'=>'required|string|min:3',
            'email'=>'required|email|unique:users,email',
            'mobile_number'=>'required|numeric|digits:10|unique:users,mobile_no',
            'address'=>'required',
            'state_name'=>'required',
            'city'=>'required|string',
            'pincode'=>'required|numeric|min_digits:6|digits:6',
            // 'shop_name'=>'required|string|min:3',
            'pancard_number'=>'required|string',
            'adhaarcard_number'=>'required|numeric|min_digits:12|digits:12',
            'scheme'=>'required',
        ])->validate();
        $user = User::create([
            'name'=>$validateData['name'],
            'email'=>$validateData['email'],
            'password'=>Hash::make($validateData['mobile_number']),
            'mobile_no'=>$validateData['mobile_number'],
            'virtual_account_number' =>"ZGROSC".$validateData['mobile_number'],
        ]);
        if($user):
            $retailer =Retailer::create([
                'user_id'=>$user->id,
                'added_by'=>auth()->user()->id,
                'mobile_no'=>$validateData['mobile_number'],
                'address'=>$validateData['address'],
                'state_id'=>$validateData['state_name'],
                'city'=>$validateData['city'],
                'pincode'=>$validateData['pincode'],
                // 'shop_name'=>$validateData['shop_name'],
                'pancard_no'=>$validateData['pancard_number'],
                'addhar_card'=>$validateData['adhaarcard_number'],
                'scheme_id'=>$validateData['scheme'],
                'website'=>$validateData['website']??NULL,
            ]);
            $user->assignRole(['retailer']);
            Wallet::create([
                'user_id'=>$user->id,
                'locked_amuont'=>"0",
            ]);
            $this->dispatch('hide-form');
            if($retailer):
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

    public function serviceUpdate($userId,$status){
        $serviceUpdate = User::findOrFail($userId)->update([
            'services'=>$status==0?"1":"0",
        ]);
        $msg = $status==0?"Service has been acctivated":"Service has been deactivated";
        return redirect()->back()->with('success',$msg);

    }

    public function changeScheme($id) {
        $this->reset();
        $this->createRetailerForm = false;
        $this->assignPermissionUserBasedForm = false;
        $this->schemeForm=true;
        $retailer = Retailer::where('user_id',$id)->first();
        $this->scheme = $retailer->scheme_id;
        $this->retailerId = $retailer->id;
        $this->dispatch('show-form');
    }

    public function setScheme() {
        $updateScheme = Retailer::where('id',$this->retailerId)->update([
            'scheme_id'=>$this->scheme
        ]);
        $this->dispatch('hide-form');
        if($updateScheme):
            sleep(1);
            return redirect()->back()->with('success','New scheme Assign Successfully !');
        else:
            DB::rollback();
            return redirect()->back()->with('error','New scheme not assign Please Try again !');
        endif;
    }

    public function assignPermissionUserBassed($id) {
        $this->reset();
        $this->createRetailerForm = false;
        $this->schemeForm=false;
        $this->assignPermissionUserBasedForm = true;
        $groups = Permission::distinct()->pluck('group');
        foreach($groups as $group) {
            $this->permission[$group] = Permission::where('group', $group)->get();
        }
        $this->user = User::find($id);
        $roleId = $this->user->roles()->first()->id;
        $roleHasPermissionCount=DB::table("model_has_permissions")->where("model_has_permissions.model_id", $this->user->id)->count();
        if($roleHasPermissionCount >0):
            $this->permissionsId = DB::table("model_has_permissions")->where("model_has_permissions.model_id", $this->user->id)->pluck('model_has_permissions.permission_id')->toArray();
        else:
            $this->permissionsId = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $roleId)->pluck('role_has_permissions.permission_id')->toArray();
        endif;
        $this->dispatch('show-form');
    }

    public function userBasedSyncPermission() {
        $upadtePermission = $this->user->syncPermissions([$this->permissionsId]);
        $this->dispatch('hide-form');
        if($upadtePermission):
            sleep(1);
            return redirect()->back()->with('success','New Permission Assign Successfully !');
        else:
            DB::rollback();
            return redirect()->back()->with('error','New Permission not assign Please Try again !');
        endif;
    }

    public function export() {
        $data = [
            'user_id'=>auth()->user()->getRoleNames()->first()!='api-partner'?$this->agentId:NULL,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'value'=>$this->value
        ];
        return Excel::download(new RetailerExport($data), time().'.xlsx');
    }

    public function generateOutletId($id) {
        $this->reset();
        $this->ekyApiPartnerId = $id;
        $this->ekycForm =true;
        $this->dispatch('show-form');
    }

    public function eKycFormData() {
        $validateData = Validator::make($this->ekycFormData,[
            'pancard_number'=>'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'adhaarcard_number'=>'required|numeric|min_digits:12|digits:12',
            'account_number'=>'required|numeric|min_digits:10',
            'ifsc_code'=>'required',


        ])->validate();
        $validateData ['agent_id']= $this->ekyApiPartnerId;
        $response = $this->signUpEkycInitiate($validateData);
        if($response['status']):
            $this->otp =true;
            $this->otpReferenceID = $response['data']['otpReferenceID'];
            $this->hash = $response['data']['hash'];
        else:
            $this->dispatch('hide-form');
            return redirect()->back()->with('error',$response['msg']);
        endif;
    }


    public function eKycValidate() {
        $this->validate();
        $data = [
            'otpReferenceID'=>$this->otpReferenceID,
            'hash'=>$this->hash,
            'otp'=>$this->otp_code,
        ];
        $response = $this->signUpEkycInitiateValidate($data);
        if($response['status']):

            User::find($this->ekyApiPartnerId)->update([
                'outlet_id'=>$response['data']['outletId'],
            ]);
            $this->reset();
            $this->dispatch('hide-form');
            return redirect()->back()->with('success',$response['msg']);
        else:
            $this->dispatch('hide-form');
            return redirect()->back()->with('error',$response['msg']);
        endif;

    }
}
