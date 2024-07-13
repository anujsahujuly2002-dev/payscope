<?php

namespace App\Http\Controllers\Mobile\Manual;

use App\Models\Bank;
use App\Models\Fund;
use App\Models\Status;
use App\Models\PaymentMode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManualRequestController extends Controller
{
    public $banks;
    public $paymentModes;
    public $agentId;
    public $value;
    public $anount;
    public $bankId;
    public $manualReq;
    public $bankName;


    // $response = $this->dashboardRepo->logout('mobile-api');

    public function manualRequest(){
        // dd('fdsfvdv');
   $data =
    $this->banks = Bank::where('status','1')->get();
        $this->paymentModes = PaymentMode::get();
        // $statuses = Status::get();
        // $funds = Fund::when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
        //     $query->where('user_id',auth()->user()->id);
        // })->when(auth()->user()->getRoleNames()->first()=='retailer',function($query){
        //     $query->where('user_id',auth()->user()->id);
        // });
        //    ->when($this->agentId !=null,function($u){
        //     $u->where('user->name)',$this->agentId);

        // });
        // ->when($this->bankId !=null,function($u){
        //     $u->where('bank->account_number',$this->bankId);
        // })
        // ->when($this->agentId !=null,function($u){
        //     $u->where('user_id',$this->agentId);
        // })
        // ->when($this->anount !=null,function($u){
        //     $u->where('moneyFormatIndia($fund->amount)',$this->anount);
        // })
        // ->when($this->bankName !=null,function($u){
        //     $u->where('bank->branch_name',$this->bankName);
        // })
        // ->when($this->value !=null,function($u){
        //     $u->where('references_no',$this->value);
        // })->latest()->paginate(10);

        // return view('livewire.admin.fund.manual-request',compact('statuses','funds'));
        return response()->json($data);
    }
}
