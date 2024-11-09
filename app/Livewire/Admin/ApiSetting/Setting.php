<?php

namespace App\Livewire\Admin\ApiSetting;

use Livewire\Component;
use App\Models\ApiToken;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Exports\ApiTokenExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Setting extends Component
{
    use WithPagination;
    public $state=[];
    protected $listeners = ['deleteConfirmed'=>'delete'];
    public $tokenId;
    public $value;
    public $end_date;
    public $agentId;
    public $editForm;
    public $id;
    // public $agentName;
    public $start_date;
    public function render()
    {
        $apiTokens = ApiToken::when(auth()->user()->getRoleNames()->first()=='api-partner',function($q){
            $q->where('user_id',auth()->user()->id);
             })->when(auth()->user()->getRoleNames()->first()=='retailer',function($q){
            $q->where('user_id',auth()->user()->id);
        })->when(auth()->user()->getRoleNames()->first()=='retailer',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);
        })->when($this->agentId !=null,function($u){
            $u->where('user_id',$this->agentId);
        })->when($this->value !=null,function($u){
            $u->where('ip_address',$this->value);
        // })->when($this->value !=null,function($u){
        //     $u->where('name',$this->agentName);
        })->paginate(10);
        return view('livewire.admin.api-setting.setting',compact('apiTokens'));
    }

    public function create() {
        if(!auth()->user()->can('callback-token-create'))
        throw UnauthorizedException::forPermissions(['callback-token-create']);
        $this->dispatch('show-form');
    }

    public function store() {
        $validateData = Validator::make($this->state,[
            'ip_address'=>'required|ip|ipv4',
            'webhook_url'=>'required|url',
            'payin_webhook_url'=>'required|url'
        ])->validate();
        $apiTokens = ApiToken::create([
            'user_id'=>auth()->user()->id,
            'ip_address'=>$validateData['ip_address'],
            'domain'=>$validateData['webhook_url'],
            'payin_webhook_url'=>$validateData['payin_webhook_url'],
            'token'=>Str::random(50),
        ]);

        $this->dispatch('hide-form');
        if($apiTokens):
            return redirect()->back()->with('success','Token genrated successfully !');
        else:
            return redirect()->back()->with('error','Token not generated Please Try again !');
        endif;
    }

    public function deleteConfirmation($id) {
        if(!auth()->user()->can('callback-token-delete')){
            throw UnauthorizedException::forPermissions(['callback-token-delete']);
        }
        $this->tokenId = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function delete() {
        ApiToken::findOrFail($this->tokenId)->delete();
        $this->dispatch('show-delete-message',[
            'message'=>"Token Delete Successfully !"
        ]);
    }

    public function export() {
        $data = [
            'user_id'=>auth()->user()->getRoleNames()->first() =='super-admin'?$this->agentId:auth()->user()->id,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'value'=>$this->value
        ];
        return Excel::download(new ApiTokenExport($data), time().'.xlsx');
    }

    public function edit($apiTokens) {
        $this->state = $apiTokens;
        $this->id = $apiTokens['id'];
        $this->state['ip_address'] = $apiTokens['ip_address'];
        $this->state['webhook_url'] = $apiTokens['domain'];
        $this->state['payin_webhook_url'] = $apiTokens['payin_webhook_url'];
        $this->editForm = true;
        $this->dispatch('show-form');
    }

    public function update() {
        $validateData = Validator::make($this->state,[
            'ip_address'=>'required|ip|ipv4',
            'webhook_url'=>'required|url',
            'payin_webhook_url'=>'required|url'
        ])->validate();
        $apiTokens = ApiToken::find($this->id)->update([
            'user_id'=>auth()->user()->id,
            'ip_address'=>$validateData['ip_address'],
            'domain'=>$validateData['webhook_url'],
            'payin_webhook_url'=>$validateData['payin_webhook_url'],
        ]);
        $this->dispatch('hide-form');
        if($apiTokens):
            return redirect()->back()->with('success','Token  has been update successfully !');
        else:
            return redirect()->back()->with('error','Token not generated Please Try again !');
        endif;
    }
}
