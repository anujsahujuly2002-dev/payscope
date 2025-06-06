<?php

namespace App\Livewire\Admin\Member;

use App\Models\User;
use App\Models\State;
use App\Models\Scheme;
use App\Models\Wallet;
use Livewire\Component;
use App\Models\ApiPartner;
use Livewire\WithPagination;
use App\Exports\ApiPartnerExport;
use App\Traits\eKYCTrait;
use Illuminate\Support\Facades\DB;
use App\Models\PayoutRequestHistory;
use App\Models\Service;
use App\Models\UserWiseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;


class ApiPartnerComponent extends Component
{
    use WithPagination,eKYCTrait;
    public $state=[];
    public $start_date;
    public $value;
    public $end_date;
    public $status;
    public $schemeForm = false;
    public $apiPartnerId;
    public $scheme;
    public $createApiPartnerForm  = false;
    public $assignPermissionUserBasedForm = false;
    public $ekycForm = false;
    public $ekycFormData = [];
    public $otp= false;
    public $permission=[];
    public $permissionsId=[];
    public $user;
    public $agentId;
    public $ekyApiPartnerId;
    public $otpReferenceID;
    public $hash;
    public $otp_code;
    protected $rules = [
        'otp_code' => 'required|integer',
    ];
    public $userWiseService;
    public $serviceForm = false;
    public $serviceLists = [];

    public $userId;
    public $walletAmount;
    public $walletForm = false; // Default hidden

    public $lockedWalletAmount;
    public $lockedWalletForm = false;
    protected $listeners = ['openWalletModal' => 'showWalletForm'];

    public function render()
    {
        if(!Auth::user()->can('api-partner-list')|| !checkRecordHasPermission(['api-partner-list'])):
            throw UnauthorizedException::forPermissions(['api-partner-list']);
        endif;
        $states = State::orderBy('name','ASC')->get();
        $schemes = Scheme::where('user_id',auth()->user()->id)->get();
        $apiPartners = User::whereHas('roles',function($q){
            $q->where('name','api-partner');
        })->when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->whereHas('apiPartner',function ($p){
                $p->where('added_by',auth()->user()->id);
            });
        })->when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })
        ->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);
        })
        ->when($this->status !== null, function ($query){
            return $query->where('status', $this->status);
        })
        ->when($this->agentId !=null,function($u){
            $u->where('user_id',$this->agentId);
        })
        ->when($this->value !=null,function($u){
            $u->where('mobile_no',$this->value)->orWhere('email',$this->value)->orWhere('name','like','%'.$this->value.'%');
        })->latest()->paginate(10);
        return view('livewire.admin.member.api-partner-component',compact('states','schemes','apiPartners'));
    }

    // This Method Api Partner Create Method
    public function createApiPartner() {

        if(!Auth::user()->can('api-partner-create') || !checkRecordHasPermission('api-partner-create')):
            throw UnauthorizedException::forPermissions(['api-partner-create']);
        endif;
        $this->reset();
        $this->createApiPartnerForm = true;
        $this->assignPermissionUserBasedForm = false;
        $this->schemeForm=false;
        $this->walletForm = false;
        $this->lockedWalletForm = false;
        $this->dispatch('show-form');
    }


    // This Method Api Partner Store
    public function StoreApiPartner() {
        $validateDate = Validator::make($this->state,[
            'name'=>'required|string|min:3',
            'mobile_number'=>'required|numeric|digits:10|unique:users,mobile_no',
            'email'=>'required|email|unique:users,email',
            'address'=>'required',
            'state_name'=>'required',
            'city'=>'required|string',
            'pincode'=>'required|numeric|min_digits:6|digits:6',
            'scheme'=>'required',
            'adhaarcard_number'=>'required|numeric|min_digits:12|digits:12',
            'company_name'=>'required|string|min:3',
            'gst'=>'required|string|min:3',
            'cin_number'=>'required|string|min:3',
            'company_pan'=>'required|string|min:3',
            'pancard_number'=>'required|string',
            // 'website'=>'required|url:https'
        ])->validate();
        $user = User::create([
            'name'=>$validateDate['name'],
            'email'=>$validateDate['email'],
            'password'=>Hash::make($validateDate['mobile_number']),
            'mobile_no'=>$validateDate['mobile_number'],
            'virtual_account_number' =>"ZGROSC".$validateDate['mobile_number'],
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
                'company_name'=>$validateDate['company_name'],
                'pancard_no'=>$validateDate['pancard_number'],
                'company_gst_number'=>$validateDate['gst'],
                'company_cin_number'=>$validateDate['cin_number'],
                'company_pan'=>$validateDate['company_pan'],
                'addhar_card'=>$validateDate['adhaarcard_number'],
                'scheme_id'=>$validateDate['scheme'],
                'website'=>$validateDate['website']??NULL,
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
            'status'=>$status==0?1:0,
        ]);
        $msg = $status==1?"Account has been deactivated":"Account has been activated";
        return redirect()->back()->with('success',$msg);

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
        $this->createApiPartnerForm = false;
        $this->assignPermissionUserBasedForm = false;
        $this->schemeForm=true;
        $partner = ApiPartner::where('user_id',$id)->first();
        $this->scheme = $partner->scheme_id;
        $this->apiPartnerId = $partner->id;
        $this->dispatch('show-form');
    }

    public function setScheme() {
        $updateScheme = ApiPartner::where('id',$this->apiPartnerId)->update([
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
        $this->createApiPartnerForm = false;
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
        return Excel::download(new ApiPartnerExport($data), time().'.xlsx');
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

    public function getServices($userId) {
        $this->createApiPartnerForm = false;
        $this->ekycForm =false;
        $this->serviceForm = true;
        $this->userWiseService = UserWiseService::where('user_id',$userId)->first();
        $this->serviceLists = Service::where('status','1')->orderBy('name','ASC')->get();
        $this->userId = $userId;
        $this->dispatch('show-form');
    }

    public function changeServiceStatus($status,$type) {
        $userWiseService = UserWiseService::where('user_id', $this->userId)->first();
        if(!is_null($userWiseService)):
            $userWiseService->update([
                'user_id'=>$this->userId,
                $type => $status==0?"1":"0", // $type is used directly as the key
            ]);
        else:
            UserWiseService::create([
                'user_id'=>$this->userId,
                $type => $status==0?"1":"0", // $type is used directly as the key
            ]);
        endif;
        if($status=='0'):
            $msg = ucfirst($type).' service has been active';
        endif;
        if($status=='1'):
            $msg = ucfirst($type).' service has been inactive';
        endif;
        $this->dispatch('hide-form');
        return redirect()->back()->with('success',$msg);
    }

    // Wallet Update method section start=========================================
    public function wallet($userId)
    {
        if (!Auth::user()->can('api-partner-create') || !checkRecordHasPermission('api-partner-create')):
            throw UnauthorizedException::forPermissions(['api-partner-create']);
        endif;
        $this->reset();
        $this->walletForm = true;
        $this->createApiPartnerForm = false;
        $this->assignPermissionUserBasedForm = false;
        $this->schemeForm = false;
        $this->lockedWalletForm = false;
        $this->serviceForm = false;
        $this->userId = $userId;

        $wallet = Wallet::where('user_id', $userId)->first();
        $this->walletAmount = $wallet->amount ? $wallet->amount : 0; // If wallet record exists, assign amount else 0
        $this->dispatch('show-form');
    }

    public function walletAmountUpdate()
    {
        $this->validate([
            'walletAmount' => 'required|numeric|min:0',
        ]);

        try {
            $wallet = DB::table('wallets')
                ->where('user_id', $this->userId)
                ->update(['amount' => $this->walletAmount]);

            if($wallet) {
                session()->flash('success', 'Wallet amount updated successfully!');
            } else {
                session()->flash('error', 'No changes detected or wallet not found.');
            }

            $this->dispatch('hide-form');

        } catch (\Exception $e) {

            \Log::error('Wallet Update Error: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the wallet amount.');
        }
    }
    // Wallet Update method section End=========================================



    // Lock wallet update section start=================================
    public function lockedWallet($userId)
    {
        if (!Auth::user()->can('api-partner-create') || !checkRecordHasPermission('api-partner-create')):
            throw UnauthorizedException::forPermissions(['api-partner-create']);
        endif;
        $this->reset();
        $this->walletForm = false;
        $this->createApiPartnerForm = false;
        $this->assignPermissionUserBasedForm = false;
        $this->schemeForm = false;
        $this->lockedWalletForm = true;
        $this->serviceForm = false;
        $this->userId = $userId;

        $lockedWallet = Wallet::where('user_id', $userId)->first();
        $this->lockedWalletAmount = $lockedWallet->locked_amuont ? $lockedWallet->locked_amuont : 0;

        $this->dispatch('show-form');

    }

    public function lockedWalletAmountUpdate()
    {
        $this->validate([
            'lockedWalletAmount' => 'required|numeric|min:0',
        ]);

        try {
            $lockedWallet = DB::table('wallets')
                ->where('user_id', $this->userId)
                ->update(['locked_amuont' => $this->lockedWalletAmount]);

            if ($lockedWallet) {
                session()->flash('success', 'Locked Wallet amount updated successfully!');
            } else {
                session()->flash('error', 'No changes detected or locked wallet not found.');
            }

            $this->dispatch('hide-form');

        } catch (\Exception $e) {

            \Log::error('Locked Wallet Update Error: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the locked wallet amount.');
        }
    }
    // Lock wallet update section End=================================


}
