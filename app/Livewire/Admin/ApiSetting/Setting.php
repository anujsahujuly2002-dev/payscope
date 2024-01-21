<?php

namespace App\Livewire\Admin\ApiSetting;

use Livewire\Component;
use App\Models\ApiToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Setting extends Component
{
    use WithPagination;
    public $state=[];
    protected $listeners = ['deleteConfirmed'=>'delete'];
    public $tokenId;
    public function render()
    {
        $apiTokens = ApiToken::where('user_id',auth()->user()->id)->paginate(10);
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
            'domain'=>'required|url'
        ])->validate();
        $apiTokens = ApiToken::create([
            'user_id'=>auth()->user()->id,
            'ip_address'=>$validateData['ip_address'],
            'domain'=>$validateData['domain'],
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
}
