<?php


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::controller(Auth\LoginController::class)->group(function() {
    Route::post('/login','login');
    Route::post('/otp-verify','otpVerify');
    Route::post('/resend-otp','resendOtp');
});
