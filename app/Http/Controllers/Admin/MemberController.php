<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class MemberController extends Controller
{
    public function apiPartner(){
        if(!Auth::user()->can('api-partner-list')):
            throw UnauthorizedException::forPermissions(['api-partner-list']);
        endif;
        return view('admin.member.api-partner-list');
    }
}
