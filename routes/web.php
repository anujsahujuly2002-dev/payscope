<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('cache-clear',function(){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    
    echo "Cache Cleared !";
});

Route::get('migrate',function(){
    Artisan::call('migrate');
    echo "Migration successfully!";
});

Route::get('/',function (){
    return to_route('admin.login');
});
Route::prefix('admin')->name('admin.')->group(function(){
    Route::namespace('Auth')->middleware(['guest'])->controller(AuthController::class)->group(function() {
        Route::get('/','login')->name('login');
    });
    Route::middleware(['auth'])->group(function() {

        // DashBoard Route
        Route::controller(DashBoardController::class)->group(function() {
            Route::get('/dashboard','dashboard')->name('dashboard');
            Route::get('/logout','logout')->name('logout');
        });

        // Role And Permission Route
        Route::controller(RoleAndPermissions::class)->group(function(){
            Route::prefix('permission')->name('permission.')->group(function() {
               Route::get('/','permissonList')->name('list');
            });
            Route::prefix('/role')->name('role.')->group(function() {
                Route::get('/','roleList')->name('list');
            });
        });

        // Member Management Route
        Route::controller(MemberController::class)->group(function(){
            Route::prefix('api-partner')->name('api.partner.')->group(function() {
                Route::get('/','apiPartner')->name('list');
                Route::get('/profile/{id}','apiPartnerProfile')->name('profile');
            });
            Route::prefix('retailer')->name('retailer.')->group(function() {
                Route::get('/','retailer')->name('list');
            });
        });

        // Setup Tools Route
        Route::controller(SetupToolsController::class)->prefix('setup')->name('setup.')->group(function(){
            Route::get('/bank','bank')->name('bank');
            Route::get('/opertator-manager','operatorManger')->name('operator.manager');
        });

        // Fund Manage Route
        Route::controller(FundController::class)->prefix('fund')->name('fund.')->group(function(){
            Route::get('/manual-request','manualRequest')->name('manual.request');
        });

        // Payout Manager Route
        Route::controller(PayoutMangerController::class)->prefix('payout')->name('payout.')->group(function() {
            Route::get('/payout-request','payoutRequest')->name('payout.request');
        });
        Route::controller(LogManagerController::class)->prefix('log-manager')->name('log.manager.')->group(function() {
            Route::get('/login-session','loginSession')->name('login.session');
        });

        // Scheme Manager Route
        Route::controller(SchemeManagerController::class)->prefix('resources')->name('resource.')->group(function() {
            Route::get('/scheme-manager','index')->name('scheme.manager');
        });

        // Api Setting Route
        Route::controller(ApiSettingController::class)->prefix('api')->name('api.')->group(function() {
            Route::get('/setting','setting')->name('setting');
        });

        // Admin Setting Route 
        Route::controller(AdminSettingController::class)->prefix('admin-setting')->name('admin-setting.')->group(function(){
            Route::get('api-list','apiList')->name('api.list');
        });

        // Recharge and bill payments Route
        Route::controller(RechargeAndBillPaymentsController::class)->prefix('recharge-and-bill-payments')->name('recharge.and.bill.payments')->group(function(){
            Route::get('/mobile-recharge','mobileRecharge')->name('mobile.recharge');
        });
    });
});
