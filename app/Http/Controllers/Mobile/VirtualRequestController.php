<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Fund;
use App\Models\Status;
use Illuminate\Http\Request;
// use App\Models\VirtualRequest;
use App\Http\Controllers\Controller;

class VirtualRequestController extends Controller
// {

//     public function virtualRequest()
//     {
//         $data = VirtualRequest::where('user_id', auth()->user()->id)->get();
//         $result = [];
//         if ($data->count() > 0) :
//             foreach ($data as $virtual) {
//                 $result[] = [
//                     'id' => $virtual->id,
//                     'user_name' => $virtual->virtualRequest->user->name,
//                     'bank_name' => $virtual->bank->name,
//                     'amount' => $virtual->amount,
//                     'account_number' => $virtual->bank->account_number,
//                     'branch_name' => $virtual->bank->branch_name,
//                     'ifsc_code' => $virtual->bank->ifsc_code,
//                 ];
//         }
//     endif;
//         return response()->json([
//             'status' => true,
//             'message' => 'Virtual Funds have been successfully.',
//             'data' => $result,
//         ], 200);
//     }
// }


// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Models\Status;
// use App\Models\VirtualRequest;
// use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\VirtualRequestExport;

// class VirtualRequestController extends Controller
{

    public function virtualRequest()
    {
        $virtualRequest = Fund::where('user_id', auth()->user()->id)->with(['user', 'bank'])->get();
        $result = [];
        if ($virtualRequest->count() > 0) :
            foreach ($virtualRequest as $virtual) {
                $result[] = [
                    'id' => $virtual->id,
                    'user_name' => $virtual->user->name,
                    'virtual_account_number' => $virtual->bank->user?->virtual_account_number,
                    'remitter_name' => $virtual->remitter_name,
                    'account_number' => $virtual->bank->account_number,
                    // 'remitter_account_number' => $virtual->bank->remitter_account_number,
                    // 'remitter_ifsc_code' => $virtual->bank->remitter_ifsc_code,
                ];
            }
            endif;

        return response()->json([
            'status' => true,
            'message' => 'Virtual Funds have been successfully.',
            'data' => $result,
            // 'statuses' => $statuses,
            // 'virtualRequests' => $virtualRequests
        ]);
    }

}

