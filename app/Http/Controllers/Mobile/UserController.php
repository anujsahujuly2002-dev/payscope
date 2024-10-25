<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Retailer;
use App\Models\ApiPartner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updatePersonalInformation(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'name' => 'required|min:3|string',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'mobile_no' => 'required|numeric|digits:10|unique:users,mobile_no,' . auth()->id(),
            'address' => 'required',
            'state_name' => 'required',
            'city' => 'required|string',
            'pincode' => 'required|numeric|digits:6',
        ])->validate();

        $user = auth()->user()->update([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            'mobile_no' => $validateData['mobile_no'],
        ]);

        if ($user) {
            $data = [
                'mobile_no' => $validateData['mobile_no'],
                'state_id' => $validateData['state_name'],
                'city' => $validateData['city'],
                'pincode' => $validateData['pincode'],
                'address' => $validateData['address'],
            ];

            $role = auth()->user()->getRoleNames()->first();
            if ($role == 'api-partner') {
                ApiPartner::where('user_id', auth()->id())->update($data);
            } else {
                Retailer::where('user_id', auth()->id())->update($data);
            }

            return response()->json(['success' => "You're personal information updated successfully!"], 200);
        } else {
            return response()->json(['error' => "You're personal information not updated, please try again!"], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password|min:8',
        ])->validate();

        $user = auth()->user();

        if (!Hash::check($validateData['old_password'], $user->password)) {
            return response()->json(['error' => "Your old password doesn't match."], 401);
        }

        $changePassword = $user->update([
            'password' => Hash::make($validateData['new_password']),
        ]);

        if ($changePassword) {
            auth()->logout();
            return response()->json(['success' => "Your password has been changed. Please log in again!"], 200);
        } else {
            return response()->json(['error' => "Your password could not be changed. Please try again."], 500);
        }
    }
}


