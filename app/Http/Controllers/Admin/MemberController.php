<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\ApiPartner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class MemberController extends Controller
{
    public function apiPartner(){
        if(!Auth::user()->can('api-partner-list') || !checkRecordHasPermission(['api-partner-list'])):
            throw UnauthorizedException::forPermissions(['api-partner-list']);
        endif;
        return view('admin.member.api-partner-list');
    }

    public function retailer() {
        return view('admin.member.retailer');
    }

    public function apiPartnerProfile ($apiPartnerId){
       return view('admin.member.profile');
    }

    public function viewProfile ($id) {
        $user =User::find(base64_decode($id));
        return view('admin.member.view-profile',compact('user'));
    }
}
