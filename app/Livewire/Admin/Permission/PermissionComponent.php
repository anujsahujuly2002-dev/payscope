<?php

namespace App\Livewire\Admin\Permission;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On; 

class PermissionComponent extends Component
{
    use WithPagination;
    
    public $state=[];
    public $editPermissionForm = false;
    public $permission;
    public $permissionId;
    public $listeners = ['deleteConfirmed'=>'deletePrmission'];
    public function render()
    {
        if(!Auth::user()->can('permission-list')):
            throw UnauthorizedException::forPermissions(['permission-list']);
        endif;
        $permissions = Permission::latest()->paginate(10);
        return view('livewire.admin.permission.permission-component',compact('permissions'));
    }

    public function addPermission() {

        if(!Auth::user()->can('permssion-create')):
            throw UnauthorizedException::forPermissions(['permssion-create']);
        endif;
        $this->state['group']='';
        $this->state['name']='';
        $this->editPermissionForm = false;
        $this->dispatch('show-form');
    }

    public function storePermission() {
        $this->state['name']= strtolower(str_replace(' ','-', $this->state['name']));
        $validateData=Validator::make($this->state,[
            'group'=>'required',
            'name'=>'required|unique:permissions,name',
        ])->validate();
        $permission=Permission::create([
            'group'=>strtolower($validateData['group']),
            'name'=>$validateData['name'],
        ]);
        $this->dispatch('hide-form');
        if($permission):
            sleep(1);
            return redirect()->back()->with('success','Permission Created Successfully !');
        else:
            return redirect()->back()->with('error','Permission Not Created Please Try again !');
        endif;

    }

    public function editPermission(Permission $permission){
        if(!Auth::user()->can('permission-edit')):
            throw UnauthorizedException::forPermissions(['permission-edit']);
        endif;
        $this->editPermissionForm =true;
        $this->permission = $permission;
        $this->state = $permission->toArray();
        $this->dispatch('show-form');
    }

    public function updatePermission() {
        $this->state['name']= strtolower(str_replace(' ','-', $this->state['name']));
        $validateData=Validator::make($this->state,[
            'group'=>'required',
            'name'=>'required|unique:permissions,name,'.$this->permission->id,
        ])->validate();
        $permission=$this->permission->update([
            'group'=>strtolower($validateData['group']),
            'name'=>$validateData['name'],
        ]);
        $this->dispatch('hide-form');
        if($permission):
            sleep(1);
            return redirect()->back()->with('success','Permission Update Successfully !');
        else:
            return redirect()->back()->with('error','Permission Not Update Please Try again !');
        endif;
    }

    public function deleteConfirmation($id) {
        if(!Auth::user()->can('permission-delete')):
            throw UnauthorizedException::forPermissions(['permission-delete']);
        endif;
        $this->permissionId = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deletePrmission(){
        Permission::findOrFail($this->permissionId)->delete();
        $this->dispatch('show-delete-message',[
            'message'=>"Permission Delete Successfully !"
        ]);
    }

}
