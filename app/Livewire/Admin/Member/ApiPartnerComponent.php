<?php

namespace App\Livewire\Admin\Member;

use App\Models\User;
use App\Models\State;
use App\Models\Scheme;
use App\Models\Status;
use App\Models\Wallet;
use Livewire\Component;
use App\Models\ApiPartner;
use Livewire\WithPagination;
use App\Exports\ApiPartnerExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ApiPartnerComponent extends Component
{
    use WithPagination;
    public $state=[];
    public $start_date;
    // public $apiPartners;
    public $value;
    public $end_date;
    public $status;
    public $schemeForm = false;
    public $apiPartnerId;
    public $scheme;
    public $createApiPartnerForm  = false;
    public $assignPermissionUserBasedForm = false;
    public $permission=[];
    public $permissionsId=[];
    public $user;
    public $agentId;



    // public function mount(){
    //     $this->apiPartners = User::whereHas('roles',function($q){
    //         $q->where('name','api-partner');
    //     })->when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
    //         $query->whereHas('apiPartner',function ($p){
    //             $p->where('added_by',auth()->user()->id);
    //         });
    //     })->latest()->paginate(10);
    // }
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
            $u->where('mobile_no',$this->value);
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
        $this->dispatch('show-form');
    }


    // This Method Api Partner Store
    public function StoreApiPartner() {
        $validateDate = Validator::make($this->state,[
            'name'=>'required|string|min:3',
            'email'=>'required|email|unique:users,email',
            'mobile_number'=>'required|numeric|digits:10|unique:users,mobile_no',
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
                'shop_name'=>$validateDate['shop_name'],
                'pancard_no'=>$validateDate['pancard_number'],
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
        // dd($userId,$status);
        $serviceUpdate = User::findOrFail($userId)->update([
            'services'=>$status==0?"1":"0",
        ]);
        // dd($serviceUpdate);
        $msg = $status==0?"Service has been acctivated":"Service has been deactivated";
        return redirect()->back()->with('success',$msg);

    }
    /* public function search() {
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
        })->when($this->status !=null,function($s){
            $s->where('status',$this->status);
        })
        ->get();
    }

*/

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
            // 'status'=>$this->status,
            'value'=>$this->value
        ];
        //  dd($data);
        return Excel::download(new ApiPartnerExport($data), time().'.xlsx');
    }


}
