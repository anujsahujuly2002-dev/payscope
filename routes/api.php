<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(FundRequestController::class)->group(function() {
    Route::post('/payout','payout');
    Route::post('/bulk-payout','bulkPayout');
    Route::post("/check-status","checkStatus");
    Route::post('/webhookpaynpro','webHookPaynPro');
});

Route::controller(QRPaymentCollectionController::class)->group(function(){
    Route::post('create-qr-code','createQrCode');
    Route::post('fetch-qr-status','fetchQrStatus');
    Route::post('upi-intent','upiIntent');
    
});
