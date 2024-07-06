<?php

namespace App\Livewire\Admin\SetupTool;

use App\Models\Benificery;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;

class BenificiaryComponent extends Component
{
    public $benificiary=[];
    public function render()
    {
        if(!auth()->user()->can('benificiary-create') || !checkRecordHasPermission(['benificiary-create'])) 
            throw UnauthorizedException::forPermissions(['benificiary-create']);
        return view('livewire.admin.setup-tool.benificiary-component');
    }

    public function benificiaryCreate(){
        if(!auth()->user()->can('benificiary-create') || !checkRecordHasPermission(['benificiary-create'])) 
            throw UnauthorizedException::forPermissions(['benificiary-create']);
        $validateData = Validator::make($this->benificiary,[
            'name'=>'required|string|min:3',
            'account_number'=>'required|numeric|min:8',
            'confirm_account_number'=>'required_with:account_number|same:account_number|min:8',
            'ifsc_code'=>'required'
        ])->validate();
        $url = "https://api.instantpay.in/payments/payout/addBeneficiary";
        $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.request()->ip()));
        $requestParameter = [
            "payer" => [
                "bankProfileId" => "24148428726",
                "accountNumber" => "923020061652668"
            ],
            "payee"   => [
                "firstName"           => $validateData['name'],
                "accountNumber"  => $validateData['account_number'],
                "ifsc"       => $validateData['ifsc_code']
            ],
            "beneficiaryType"       => "AXIS",
            "otp"                => "",
            "otpReference"       => ""
        ];

        $headers = [
            'X-Ipay-Auth-Code'=>'1',
            'X-Ipay-Client-Id'=>'YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=',
            'X-Ipay-Client-Secret'=>'051093090b6671f1be11b91eed4091a220c37c51d321f064a25260f6a697114f',
            'X-Ipay-Endpoint-Ip'=>request()->ip(),
            'Content-Type'=>'application/json'
        ];

        $res = apiCall($headers,$url,$requestParameter,true);
        $benificiary = Benificery::create([
            'name'=>$validateData['name'],
            'account_number'=>$validateData['account_number'],
            'ifcs_code'=>$validateData['ifsc_code'],
            'listed_id'=>$res['orderid'],
            'type'=>'0',
            'added_by'=>auth()->user()->id,
        ]);
        $this->reset();
        if($benificiary):
            return redirect()->back()->with('success',$res['status']);
        else:
            return redirect()->back()->with('error','Benificiary not added,Please try again !');
        endif;


    }
}
