<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Mobile\UserController;
use App\Http\Controllers\Mobile\CommonController;
use App\Http\Controllers\Mobile\DashboardController;
use App\Http\Controllers\Mobile\Auth\LoginController;
use App\Http\Controllers\Mobile\SetUpToolsController;
use App\Http\Controllers\Mobile\PayoutRequestController;
use App\Http\Controllers\Mobile\VirtualRequestController;
use App\Http\Controllers\Mobile\Auth\ForgetPasswordController;
use App\Http\Controllers\Mobile\Manual\ManualRequestController;

Route::controller(LoginController::class)->group(function() {
    Route::post('/login','login');
    Route::post('/otp-verify','otpVerify');
    Route::post('/resend-otp','resendOtp');
});


Route::get('/send-verify-mail/{email}', [ForgetPasswordController::class, 'sendVerifyMail']);

Route::post('/forgot-password', [ForgetPasswordController::class, 'forgetPassword']);
// Route::post('/reset-password', [ForgetPasswordController::class, 'reset'])->name('password.reset');

Route::group(['middleware' => 'auth:api'], function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/logout','logout');
    });

    Route::controller(ManualRequestController::class)->prefix('fund')->group(function(){
        Route::get('/manual-request','manualRequest');
        Route::post('/create-manual-request','createManualRequest');
    });

    Route::controller(VirtualRequestController::class)->prefix('fund')->group(function(){
        Route::get('/virtul-request','virtualRequest');
    });
    Route::controller(PayoutRequestController::class)->prefix('fund')->group(function(){
        Route::get('/payout-request','payoutRequest');
        Route::post('/create-payout-request','createPayoutNewRequest');
    });

    Route::get('payment-modes', [CommonController::class, 'paymentModeList']);
    Route::get('bank-list', [CommonController::class, 'bankList']);
    Route::get('status-list', [CommonController::class, 'getStatusList']);

});
Route::group(['middleware' => 'auth:api'], function(){
    Route::controller(UserController::class)->group(function(){
        Route::put('/user-update','updatePersonalInformation');
        Route::post('/change-password','changePassword');
    });
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::controller(SetUpToolsController::class)->group(function(){
        Route::post('/store-bank','store');
    });
});



