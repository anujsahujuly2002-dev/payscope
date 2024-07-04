<?php

namespace App\Livewire\Admin\AdminSetting;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SettingComponent extends Component
{

    public $otpEnabled ;
    
    public function OtpEnabled($key,$value){
     
        Setting::where('key','otp-verification')->update([
            'key' => $key,
            'value' => $value ? 'false' : 'true',
       ]);
    //    dd($value,$key);
    }

    public function mount()
    {
        $this->otpEnabled = DB::table('settings')->where('key', 'otp-verification')->value('value');
    }

    

    public function render()
    {
        return view('livewire.admin.admin-setting.setting-component');
    }

}
