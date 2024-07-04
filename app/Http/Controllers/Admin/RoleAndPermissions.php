<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;

class RoleAndPermissions extends Controller
{
    public function permissonList() {
        if(!Auth::user()->can('permission-list')){
            throw UnauthorizedException::forPermissions(['role-list']);
        }
        return view('admin.permission.index');
    }


    public function roleList() {
        if(!Auth::user()->can('role-list')){
            throw UnauthorizedException::forPermissions(['role-list']);
        }
        return view('admin.role.index');
    }
}
