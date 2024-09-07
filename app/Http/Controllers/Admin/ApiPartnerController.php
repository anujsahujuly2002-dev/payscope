<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ApiPartnerController extends Controller
{
    public function generateOutlet($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $apiData = [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer YOUR_API_TOKEN',
        ])->post('https://api.instantpay.in/v1/outlet/onboard', $apiData);

        if ($response->successful()) {
            $outletId = $response->json('outlet_id');

            $user->outlet_id = $outletId;
            $user->save();

            return response()->json(['message' => 'Outlet ID generated successfully', 'outlet_id' => $outletId]);
        } else {
            return response()->json(['message' => 'Failed to generate outlet ID', 'error' => $response->json()], 500);
        }
    }
}

