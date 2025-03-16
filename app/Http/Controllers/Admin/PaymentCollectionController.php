<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentCollectionController extends Controller
{
    public function index() {
        return view('admin.payment-collection.index');
    }

    public function phonePeCallback(Request $request) {
        return redirect()->route('admin.payment.collection.index')->with('success',"Payment successfully complete");
    }
}
