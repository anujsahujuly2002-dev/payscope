<?php

namespace App\Livewire\Admin\AdminSetting;

use App\Models\Api;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class ApiListComponent extends Component
{
    use WithPagination;
    public $state=[];
    public $id;
    public $editForm = false;
    public function render()
    {
        if(!auth()->user()->can('api-list'))
        return UnauthorizedException::forPermissions(['api-list']);
        $apiLists = Api::latest()->paginate(10);
        return view('livewire.admin.admin-setting.api-list-component',compact('apiLists'));
    }

    public function create() {
        if(!auth()->user()->can('api-create'))
        return UnauthorizedException::forPermissions(['api-create']);
        $this->editForm = false;
        $this->reset();
        $this->dispatch('show-form');
    }

    public function store() {
        // dd($this->state);
        $validateData = Validator::make($this->state,[
            'api_name'=>'required',
            'api_code'=>'required',
            'api_url'=>'required',
            'username'=>'required',
            'product_type'=>'required',
        ])->validate();
        $validateData['password'] = $this->state['password'];
        $validateData['optional1'] = $this->state['optional1'];
        // dd($validateData);
        $api = Api::create([
            'name'=>$validateData['api_name'],
            'code'=>$validateData['api_code'],
            'url'=>$validateData['api_url'],
            'username'=>$validateData['username'],
            'password'=>$validateData['password']??NULL,
            'optional'=>$validateData['optional1']??NULL,
            'type'=>$validateData['product_type'],
            'status'=>'1',
        ]);
        $this->dispatch('hide-form');
        if($api):
            return redirect()->back()->with('success','Api Added Successfully !');
        else:
            return redirect()->back()->with('error','Api not Added Not added,Please try again !');
        endif;

    }

    public function statusUpdate($id,$status) {
        $statusUpdate = Api::findOrFail($id)->update([
            'status'=>$status==0?1:0,
        ]);

        return redirect()->back()->with('success','Your Status has been updated');
    }

    public function edit($api){
        $this->id = $api['id'];
        $this->state['api_name'] = $api['name'];
        $this->state['api_code'] = $api['code'];
        $this->state['api_url'] = $api['url'];
        $this->state['username'] = $api['username'];
        $this->state['password'] = $api['password'];
        $this->state['optional1'] = $api['optional'];
        $this->state['product_type'] = $api['type'];
        $this->editForm = true;
        $this->dispatch('show-form');
    }

    public function update() {
        $validateData = Validator::make($this->state,[
            'api_name'=>'required',
            'api_code'=>'required',
            'api_url'=>'required',
            'username'=>'required',
            'product_type'=>'required',
        ])->validate();
        $api = Api::findOrFail($this->id)->update([
            'name'=>$validateData['api_name'],
            'code'=>$validateData['api_code'],
            'url'=>$validateData['api_url'],
            'username'=>$validateData['username'],
            'password'=>$validateData['password']??NULL,
            'optional'=>$validateData['optional1']??NULL,
            'type'=>$validateData['product_type'],
            'status'=>'1',
        ]);
        $this->dispatch('hide-form');
        if($api):
            return redirect()->back()->with('success','Api update Successfully !');
        else:
            return redirect()->back()->with('error','Api not update Not added,Please try again !');
        endif;
    }
}
