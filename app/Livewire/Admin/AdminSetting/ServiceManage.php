<?php

namespace App\Livewire\Admin\AdminSetting;

use App\Models\Api;
use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ServiceManage extends Component
{
    use WithPagination;
    public $editForm =false;
    public $service;
    public $state = [];
    public function render()
    {
        $apis = Api::orderBy('name','desc')->get();
        $services = Service::latest()->paginate(10);
        return view('livewire.admin.admin-setting.service-manage',compact('apis','services'));
    }

    public function create() {
        if(!auth()->user()->can('service-create') || !checkRecordHasPermission(['service-create']))
        return UnauthorizedException::forPermissions(['service-create']);
        $this->editForm = false;
        $this->reset();
        $this->dispatch('show-form');
    }

    public function store() {
        $validateData = Validator::make($this->state,[
            'service_name'=>'required|unique:services,name',
            'api_name'=>'required',
        ])->validate();
        $service = Service::create([
            'name'=>$validateData['service_name'],
            'api_id'=>$validateData['api_name'],
            'status'=>'1',
        ]);

        $this->dispatch('hide-form');
        if($service):
            sleep(1);
            return redirect()->back()->with('success','Services added successfully !');
        else:
            sleep(1);
            return redirect()->back()->with('error','Services not added ,Please try again !');
        endif;
    }

    public function edit(Service $service){
        $this->service = $service;
        $this->state['service_name'] = $this->service->name;
        $this->state['api_name'] = $this->service->api_id;
        $this->editForm = true;
        $this->dispatch('show-form');
    }

    public function update() {
        $validateData = Validator::make($this->state,[
            'service_name'=>'required|unique:services,name,'.$this->service->id,
            'api_name'=>'required',
        ])->validate();
        $service = $this->service->update([
            'name'=>$validateData['service_name'],
            'api_id'=>$validateData['api_name'],
            'status'=>'1',
        ]);

        $this->dispatch('hide-form');
        if($service):
            sleep(1);
            return redirect()->back()->with('success','Services update successfully !');
        else:
            sleep(1);
            return redirect()->back()->with('error','Services not update ,Please try again !');
        endif;
    }

    public function statusUpdate($id,$status) {
        $statusUpdate = Service::findOrFail($id)->update([
            'status'=>$status=="0"?"1":"0",
        ]);

        return redirect()->back()->with('success','Your Status has been updated');
    }

}
