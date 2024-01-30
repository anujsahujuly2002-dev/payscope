<?php

namespace App\Livewire\Admin\SetupTool;

use App\Models\Api;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OperatorManager;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;

class OperaterManagerComponent extends Component
{
    use WithPagination;
    public $operatorLists = [];
    public $editFormOperaterManger = false;
    public $operatorManagerId;
    public $api;
    public function render()
    {
        if(!auth()->user()->can('operator-list')) 
        throw UnauthorizedException::forPermissions(['operator-list']);
        $apis = Api::where('status','1')->get(['id','name']);
        $operatorManagers = OperatorManager::latest()->paginate(10);
        return view('livewire.admin.setup-tool.operater-manager-component',compact('apis','operatorManagers'));
    }

    public function create() {
       
        if(!auth()->user()->can('operator-create')) 
            throw UnauthorizedException::forPermissions(['operator-create']);
        $this->editFormOperaterManger = false;
        $this->reset();
        $this->dispatch('show-form');
    }

    public function store() {
        $validateData = Validator::make($this->operatorLists,[
            'name'=>'required|string|min:3',
            'operator_type'=>'required',
            'api_id'=>'required',
            'charge_range'=>'required_if:operator_type,dmt|regex:/^\d+-\d+$/'
        ])->validate();
        $chargeRange = explode('-',$validateData['charge_range']??0);
        $operatorManager = OperatorManager::create([
            'name'=>$validateData['name'],
            'operator_type'=>$validateData['operator_type'],
            'api_id'=>$validateData['api_id'],
            'charge_range_start' =>$chargeRange[0]??0, 
            'charge_range_end' =>$chargeRange[1]??0, 
            'status'=>'1',
        ]);
        
        $this->dispatch('hide-form');
        if($operatorManager):
            return redirect()->back()->with('success','Operator Added Successfully !');
        else:
            return redirect()->back()->with('error','Operator not added,Please try again !');
        endif;
    }

    public function statusUpdate($id,$status) {
        if(!auth()->user()->can('operator-manager-status-change')) 
            throw UnauthorizedException::forPermissions(['operator-manager-status-change']);
        $statusUpdate = OperatorManager::findOrFail($id)->update([
            'status'=>$status==0?"1":"0",
        ]);
        
        if($status=='0'):
            $msg = "Operator Manager Active Successfully";
        else:
            $msg = "Operator Manager Inactive Successfully";
        endif;
        if($statusUpdate):
            $this->dispatch('hide-form');   
            return redirect()->back()->with('success',$msg);
        else:
            $this->dispatch('hide-form');
            return redirect()->back()->with('enter','Operator not update, Please try again');
        endif;
    }

    public function edit(OperatorManager $operatorManager){
        if(!auth()->user()->can('operator-edit')) 
        throw UnauthorizedException::forPermissions(['operator-edit']);
        $this->editFormOperaterManger = true;
        $this->operatorManagerId = $operatorManager->id;
        $this->operatorLists = $operatorManager->toArray();
        $this->dispatch('show-form');
    }

    public function  update() {
        $validateData = Validator::make($this->operatorLists,[
            'name'=>'required|string|min:3',
            'operator_type'=>'required',
            'api_id'=>'required',
            'charge_range'=>'required|regex:/^\d+-\d+$/'
        ])->validate();
        $chargeRange = explode('-',$validateData['charge_range']);
        $operatorManager = OperatorManager::where('id',$this->operatorManagerId)->update([
            'name'=>$validateData['name'],
            'operator_type'=>$validateData['operator_type'],
            'api_id'=>$validateData['api_id'],
            'charge_range_start' =>$chargeRange[0], 
            'charge_range_end' =>$chargeRange[1], 
            'status'=>'1',
        ]);
        
        $this->dispatch('hide-form');
        if($operatorManager):
            return redirect()->back()->with('success','Operator updated Successfully !');
        else:
            return redirect()->back()->with('error','Operator not update,Please try again !');
        endif;
    }
}
