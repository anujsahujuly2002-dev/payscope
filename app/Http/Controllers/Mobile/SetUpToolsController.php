<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SetUpToolsController extends Controller
{
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'account_number' => 'required|numeric|min:5',
            'ifsc_code' => 'required',
            'branch_name' => 'required'
        ])->validate();

        $validateData['user_id'] = Auth::id();

        $bank = Bank::create($validateData);

        return response()->json([
            'success' => true,
            'message' => 'Bank Added Successfully!',
            'data' => $bank,
        ], 201);
    }
}
