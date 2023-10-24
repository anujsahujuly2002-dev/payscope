<?php

namespace App\Livewire\Admin\SetupTool;

use Livewire\Component;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Validator;
use App\Models\Bank;

class BankComponent extends Component
{
    public $state=[];
    public $editBankForm;
    public $bank;
    public $bankId;
    public $listeners = ['deleteConfirmed'=>'deleteBank'];
    public function render()
    {
        if(!auth()->user()->can('bank-list')):
            throw UnauthorizedException::forPermissions(['bank-list']);
        endif;
       $banks = Bank::where('user_id',auth()->user()->id)->latest()->get();
        return view('livewire.admin.setup-tool.bank-component',compact('banks'));
    }

    public function bankCreate() {
        if(!auth()->user()->can('bank-create')):
        endif;
        $this->editBankForm =false;
        $this->dispatch('show-form');
    }

    public function storeBank() {
        $validateData = Validator::make($this->state,[
            'name'=>'required|string|min:3',
            'account_number'=>'required|numeric|min:5',
            'ifsc_code'=>'required',
            'branch_name'=>'required'
        ])->validate();
        $validateData['user_id']= auth()->user()->id;
        $banks = Bank::create($validateData);
        $this->dispatch('hide-form');
        if($banks):
            return redirect()->back()->with('success','Bank Added Successfully !');
        else:
            return redirect()->back()->with('error','Bank Not Added Please Try Again !');
        endif;
    }

    public function statusUpdate($userId,$status){
        $statusUpdate = Bank::findOrFail($userId)->update([
            'status'=>$status ==1?'0':'1',
        ]);
        if($statusUpdate):
            return redirect()->back()->with('success','Your Status has been updated');
        else:
            return redirect()->back()->with('error','Your Status Not Updated');
        endif;
       
    }

    public function edit(Bank $bank) {
        if(!auth()->user()->can('bank-edit')):
            throw UnauthorizedException::forPermissions(['bank-edit']);
        endif;
        $this->editBankForm =true;
        $this->bank = $bank;
        $this->state = $bank->toArray();
        $this->dispatch('show-form');
    }

    public function updateBank() {
        $validateData = Validator::make($this->state,[
            'name'=>'required|string|min:3',
            'account_number'=>'required|numeric|min:5',
            'ifsc_code'=>'required',
            'branch_name'=>'required'
        ])->validate();

        $banks=$this->bank->update($validateData);
        $this->dispatch('hide-form');
        if($banks):
            return redirect()->back()->with('success','Bank Update Successfully');
        else:
            return redirect()->back()->with('error','Bank Not Update,Please try again !');
        endif;
    }

    public function deleteConfirmation($id) {
        if(!auth()->user()->can('bank-delete')):
            throw UnauthorizedException::forPermissions(['bank-delete']);
        endif;
        $this->bankId = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteBank(){
        Bank::findOrFail($this->bankId)->delete();
        $this->dispatch('show-delete-message',[
            'message'=>"Permission Delete Successfully !"
        ]);
    }
}
