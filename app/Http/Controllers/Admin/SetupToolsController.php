<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SetupToolsController extends Controller
{
    public function bank (){
        return view('admin.setup-tools.bank');
    }

    public function operatorManger() {
        return view('admin.setup-tools.operator-manager');
    }

    public function benificiaryManage() {
        return view('admin.setup-tools.benificiary');
    }
}
