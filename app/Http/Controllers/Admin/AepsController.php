<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AepsController extends Controller
{



    public function aepsServices() {
        return view('admin.aeps.aeps-system');
    }
}
