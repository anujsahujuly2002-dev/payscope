<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PayoutMangerController extends Controller
{
    public function payoutRequest () {
        return view('admin.payout.payout-request');
    }

    public function disputes() {
        if(!Auth::user()->can('disputes-list') || !checkRecordHasPermission(['disputes-list']))
        throw UnauthorizedException::forPermissions(['disputes-list']);
        return view('admin.fund-manager.disputes');
    }
}
