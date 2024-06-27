<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function apiList() {
        return view('admin.admin-setting.api-list');
    }

    public function manageService() {
        return view('admin.admin-setting.manage-service');
    }
    
    public function manageSetting() {
        return view('admin.admin-setting.settings');
    }
}
