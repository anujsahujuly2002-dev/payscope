<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::controller(Auth\LoginController::class)->group(function() {
    Route::post('/login','login');
    Route::post('/otp-verify','otpVerify');
    Route::post('/resend-otp','resendOtp');
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/logout','logout');
    });
    // Route::get('logout', 'logout');
});
