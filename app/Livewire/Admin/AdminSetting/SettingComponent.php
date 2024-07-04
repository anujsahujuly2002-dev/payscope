<?php

namespace App\Livewire\Admin\AdminSetting;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SettingComponent extends Component
{

    
    public function OtpEnabled($key,$value){
        Setting::where('key',$key)->update([
            'key' => $key,
            'value' => $value=='no' ? 'yes' : 'no',
       ]);
    //    dd($value,$key);
    }

    

    public function render()
    {
        $otpEnabled = Setting::where('key', 'otp verification')->first(['value']);
        return view('livewire.admin.admin-setting.setting-component',compact('otpEnabled'));
    }

}
