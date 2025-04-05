<?php

namespace App\Livewire\Admin\Resources;

use App\Models\Commission;
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
    public $operaterType;
    public $slab = [];
    public $items = [];

    protected $rules = [
        'schemeName' => 'required|string:min:3',
    ];

    public function render()
    {
        if(!auth()->user()->can('scheme-manager-list'))
        throw UnauthorizedException::forPermissions(['scheme-manager-list']);
        $schemes = Scheme::when(auth()->user()->getRoleNames()->first()=='api-partner',function($q){
            $q->where('user_id',auth()->user()->id);
        })->latest()->paginate(10);
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
        $value['name']=$this->schemeName;
        $data =[
            'activity'=>'Scheme Create',
            'ip_address'=>request()->ip(),
            'last_modify_id'=>auth()->user()->id,
            'changes'=>json_encode($value)
        ];
        storeUserActivityLog($data);
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
        $value['scheme_id']=$id;
        $value['status']=$status =="1"?"0":"1";
        $data =[
            'activity'=>'Scheme status changes',
            'ip_address'=>request()->ip(),
            'last_modify_id'=>auth()->user()->id,
            'changes'=>json_encode($value)
        ];
        storeUserActivityLog($data);
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
        $value['name']=$this->schemeName;
        $data =[
            'activity'=>'Scheme Update',
            'ip_address'=>request()->ip(),
            'last_modify_id'=>auth()->user()->id,
            'changes'=>json_encode($value)
        ];
        storeUserActivityLog($data);
        if($scheme):
            $this->dispatch('hide-form');

            return redirect()->back()->with('success',"Scheme Update Succcessfully");
        else:
            $this->dispatch('hide-form');
            return redirect()->back()->with('enter','Scheme not update, Please try again');
        endif;
    }


    public function getCommission($scheme,$operaterName){
        $this->reset();
        $this->setCommissionForm = TRUE;
        if($operaterName =='payout'):
            $this->operaterName = $operaterName;
            $this->commissionTypeTitle = 'Money Transfer';
        endif;
        $this->operaterType =$operaterName;
        $this->operaterList = OperatorManager::where('operator_type',$operaterName)->get();
        $this->items = array_map(fn($operaterList)=>$operaterList->id,iterator_to_array($this->operaterList));
        $this->schemeId = $scheme;
        $commisions = Commission::where(['operator'=>$operaterName,'scheme_id'=>$this->schemeId])->orderBy('slab_id','ASC')->get();
        foreach($commisions as $commision):
            $this->slab[] = [
                'type'=>$commision->type,
                'value'=>$commision->value,
                'gst'=>$commision->gst
            ];
        endforeach;
        $this->dispatch('show-form');
    }

    public function storeCommission() {
        foreach($this->slab as $key =>$value):
            $commission = Commission::where(['slab_id'=>$this->items[$key],'scheme_id'=>$this->schemeId])->first();
            if($commission !=null):
                $commission->update([
                    'operator'=> $this->operaterType,
                    'type'=>$value['type'],
                    'value'=>$value['value'],
                    'gst'=>$value['gst']?"1":"0"
                ]);
                $value['scheme_id'] = $this->schemeId;
                $value['slab_id'] = $commission->id;
                $value['charge_type'] = $this->operaterType;
                $data =[
                    'activity'=>'Commision Update',
                    'ip_address'=>request()->ip(),
                    'last_modify_id'=>auth()->user()->id,
                    'changes'=>json_encode($value)
                ];
                storeUserActivityLog($data);
            else:
                Commission::create([
                    'scheme_id'=>$this->schemeId,
                    'slab_id'=>$this->items[$key],
                    'operator'=> $this->operaterType,
                    'type'=>$value['type'],
                    'gst'=>array_key_exists('gst',$value)?($value['gst']?"1":"0"):"0",
                    'value'=>$value['value'],
                ]);
                $value['scheme_id'] = $this->schemeId;
                $value['slab_id'] = $this->items[$key];
                $value['charge_type'] = $this->operaterType;
                $data =[
                    'activity'=>'New Commision Create',
                    'ip_address'=>request()->ip(),
                    'last_modify_id'=>auth()->user()->id,
                    'changes'=>json_encode($value)
                ];
                storeUserActivityLog($data);
            endif;
        endforeach;
        $this->dispatch('hide-form');
        return redirect()->back()->with('success',"Commission Update Successfully");
    }


}
