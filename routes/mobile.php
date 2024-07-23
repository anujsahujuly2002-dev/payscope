<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Mobile\DashboardController;
use App\Http\Controllers\Mobile\Manual\ManualRequestController;

Route::controller(Auth\LoginController::class)->group(function() {
    Route::post('/login','login');
    Route::post('/otp-verify','otpVerify');
    Route::post('/resend-otp','resendOtp');
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/logout','logout');
    });
    Route::controller(ManualRequestController::class)->prefix('fund')->group(function(){
        Route::get('/manual-request','manualRequest');
        Route::post('/create-manualRequest','createManualRequest');
        // Route::get('/virtul-request','virtualRequest')->name('virtual.request');
    });
});



