<?php

namespace App\Livewire\Admin\Resources;

use App\Models\OperatorManager;
use App\Models\Scheme;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Exceptions\UnauthorizedException;

class SchemeManagerComponent extends Component
{
    use WithPagination;
    public $schemeName;
    public $editSchemeForm;
    public $schemeId;
    public $operaterList;
    public $setCommissionForm = false;
    public $commissionTypeTitle ;
    public $operaterName;
    protected $rules = [
        'schemeName' => 'required|string:min:3',
    ];
    public function render()
    {
        $schemes = Scheme::latest()->paginate(10);
        return view('livewire.admin.resources.scheme-manager-component',compact('schemes'));
    }


    public function create() {
        if(!auth()->user()->can('scheme-manager-create')) 
        throw UnauthorizedException::forPermissions(['scheme-manager-create']);
        $this->editSchemeForm =false;
        $this->setCommissionForm = false;
        $this->dispatch('show-form');
    }

    public function store() {
        $this->validate();
        $scheme = Scheme::create([
            'user_id'=>auth()->user()->id,
            'name'=>$this->schemeName,
            'status'=>'1',
        ]);
        if($scheme):
            $this->dispatch('hide-form');
            return redirect()->back()->with('success','Scheme Added Successfully');
        else:
            $this->dispatch('hide-form');
            return redirect()->back()->with('enter','Scheme not added, Please try again');
        endif;
    }

    public function statusUpdate($id,$status){
        if(!auth()->user()->can('scheme-manager-status-change')) 
        throw UnauthorizedException::forPermissions(['scheme-manager-status-change']);
        $scheme = Scheme::where('id',$id)->update([
            'status'=>$status =="1"?"0":"1",
        ]);
        if($status=='0'):
            $msg = "Scheme Active Successfully";
        else:
            $msg = "Scheme Inactive Successfully";
        endif;
        if($scheme):
            $this->dispatch('hide-form');

            return redirect()->back()->with('success',$msg);
        else:
            $this->dispatch('hide-form');
            return redirect()->back()->with('enter','Scheme not update, Please try again');
        endif;
    }

    public function edit($scheme){
        // dd($scheme);
        $this->editSchemeForm=True;
        $this->schemeId = $scheme['id'];
        $this->schemeName = $scheme['name'];
        $this->dispatch('show-form');
    }

    public function update(){
        $this->validate();
        $scheme = Scheme::where('id',$this->schemeId)->update([
            'user_id'=>auth()->user()->id,
            'name'=>$this->schemeName,
            'status'=>'1',
        ]);
        if($scheme):
            $this->dispatch('hide-form');

            return redirect()->back()->with('success',"Scheme Update Succcessfully");
        else:
            $this->dispatch('hide-form');
            return redirect()->back()->with('enter','Scheme not update, Please try again');
        endif;
    }


    public function getCommission($scheme,$operaterName){
        $this->setCommissionForm = TRUE;
        if($operaterName =='dmt'):
            $this->operaterName = $operaterName;
            $this->commissionTypeTitle = 'Money Transfer';
        endif;
        $this->operaterList = OperatorManager::where('operator_type',$operaterName)->get();
        $this->dispatch('show-form');
    }


}
