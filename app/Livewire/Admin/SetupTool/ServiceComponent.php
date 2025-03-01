<?php

namespace App\Livewire\Admin\SetupTool;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;


class ServiceComponent extends Component
{
    use WithPagination;
    public $editForm = false;
    public $service = [];
    public $serviceId;

    public function render()
    {
        $services = Service::latest()->paginate(10);
        return view('livewire.admin.setup-tool.service-component',compact('services'));
    }

    public function create() {
        if(!auth()->user()->can('charge-slab-create')) 
        throw UnauthorizedException::forPermissions(['operator-create']);
        $this->editForm = false;
        $this->reset();
        $this->dispatch('show-form');
    }

    public function store() {
        $validateData = Validator::make($this->service,[
            'name'=>'required|string|min:3',
        ])->validate();
        $services = Service::create([
            'name'=>$validateData['name'],
            'status'=>'1',
        ]);
        
        $this->dispatch('hide-form');
        if($services):
            return redirect()->back()->with('success','Service Added Successfully !');
        else:
            return redirect()->back()->with('error','Service not added,Please try again !');
        endif;
    }

    public function statusUpdate($id,$status) {
        if(!auth()->user()->can('charge-slabs-status-change')) 
        throw UnauthorizedException::forPermissions(['operator-manager-status-change']);
        $statusUpdate = Service::findOrFail($id)->update([
            'status'=>$status==0?"1":"0",
        ]);
        
        if($status=='0'):
            $msg = "Service Active Successfully";
        else:
            $msg = "Service Inactive Successfully";
        endif;
        if($statusUpdate):
            $this->dispatch('hide-form');   
            return redirect()->back()->with('success',$msg);
        else:
            $this->dispatch('hide-form');
            return redirect()->back()->with('enter','Operator not update, Please try again');
        endif;
    }

    public function edit(Service $service){
        if(!auth()->user()->can('charges-slab-edit')) 
        throw UnauthorizedException::forPermissions(['operator-edit']);
        $this->editForm = true;
        $this->serviceId = $service->id;
        $this->service = $service->toArray();
        $this->dispatch('show-form');
    }

    public function  update() {
        $validateData = Validator::make($this->service,[
            'name'=>'required|string|min:3',
        ])->validate();
        $services = Service::where('id',$this->serviceId)->update([
            'name'=>$validateData['name'],
            'status'=>'1',
        ]);
        $this->dispatch('hide-form');
        $this->dispatch('hide-form');
        if($services):
            return redirect()->back()->with('success','Service Update Successfully !');
        else:
            return redirect()->back()->with('error','Service not Update,Please try again !');
        endif;
    }
}
