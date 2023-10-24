<?php

namespace App\Livewire\Admin\Role;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleComponent extends Component
{
    use WithPagination;
    public $name;
    public $permissionsId = [];
    public $permissionsValue=[];
    protected $listeners = ['deleteConfirmed'=>'deleteRole'];
    public $roleId;
    public $role;
    public $editRoleForm = false;
    // public $roles;
    protected $rules = [
        'name' => 'required|unique:roles',
        'permissionsId' => 'required',
    ];
    protected $messages = [
        'permissionsId.required' => 'The permissions field is required.',
    ];
    public function render()
    {
        if(!Auth::user()->can('role-list')){
            throw UnauthorizedException::forPermissions(['role-list']);
        }
        
        $roles = Role::paginate(10);
        $permission = [];
        $groups = Permission::distinct()->pluck('group');
        foreach($groups as $group) {
            $permission[$group] = Permission::where('group', $group)->get();
        }
        return view('livewire.admin.role.role-component',compact('roles','permission'));
    }

    public function createRole() {
        if(!Auth::user()->can('role-create')){
            throw UnauthorizedException::forPermissions(['role-create']);
        }
        $this->reset();
        $this->editRoleForm = false;
        $this->dispatch('show-form');
    }

    public function storeRole(){
        $this->validate();
        $role = Role::create([
            'name'=>str_replace(' ','-',strtolower($this->name))
        ]);
        $role->givePermissionTo($this->permissionsId);
        $this->dispatch('hide-form');
        if($role):
            sleep(1);
            return redirect()->back()->with('success','Role Created Successfully !');
        else:
            sleep(1);
            return redirect()->back()->with('success','Role Not Created, Please try again !');
        endif;
    }

    public function deleteConfirmation($id) {
        if(!Auth::user()->can('role-delete')){
            throw UnauthorizedException::forPermissions(['role-delete']);
        }
        $this->roleId = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteRole() {
        Role::findOrFail($this->roleId)->delete();
        $this->dispatch('show-delete-message',[
            'message'=>"Role Delete Successfully !"
        ]);
    }

    public function editRole(Role $role){
        if(!Auth::user()->can('role-edit')){
            throw UnauthorizedException::forPermissions(['role-edit']);
        }
        $this->reset();
       $this->editRoleForm = true;
       $this->role = $role;
       $this->name = ucfirst(str_replace('-',' ',$role->name));
       $this->permissionsId = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)->pluck('role_has_permissions.permission_id')->toArray();
       $this->dispatch('show-form');
    }

    public function updateRole() {
        $role=$this->role->update([
            'name' => str_replace(' ','-',strtolower($this->name))
           ]);
        $this->role->syncPermissions($this->permissionsId);
        $this->dispatch('hide-form');
        if($role):
            sleep(1);
            return redirect()->back()->with('success','Role Update Successfully !');
        else:
            sleep(1);
            return redirect()->back()->with('success','Role Not Update, Please try again !');
        endif;
    }
}
