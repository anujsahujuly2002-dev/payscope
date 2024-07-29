<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\AepsController;
use App\Http\Controllers\Admin\FundController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\RoleAndPermissions;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\ApiSettingController;
use App\Http\Controllers\Admin\LogManagerController;
use App\Http\Controllers\Admin\SetupToolsController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\PayoutMangerController;
use App\Http\Controllers\Admin\SchemeManagerController;
use App\Http\Controllers\Admin\RechargeAndBillPaymentsController;

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
    sendOtp("9305238392",'3421');
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
        Route::get('/otp-verification',function() {
            return view('admin.auth.otp-verification');
        })->name('otp.vrification');
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
            Route::get('view-profile/{id}','viewProfile')->name('view.profile');
        });

        // Setup Tools Route
        Route::controller(SetupToolsController::class)->prefix('setup')->name('setup.')->group(function(){
            Route::get('/bank','bank')->name('bank');
            Route::get('/opertator-manager','operatorManger')->name('operator.manager');
            Route::get('/benificiary-manage','benificiaryManage')->name('benificiary.manage');
        });

        // Fund Manage Route
        Route::controller(FundController::class)->prefix('fund')->name('fund.')->group(function(){
            Route::get('/manual-request','manualRequest')->name('manual.request');
            Route::get('/virtul-request','virtualRequest')->name('virtual.request');
            Route::get('/qr-request','qrRequest')->name('qr.request');
        });

        // Payout Manager Route
        Route::controller(PayoutMangerController::class)->prefix('payout')->name('payout.')->group(function() {
            Route::get('/payout-request','payoutRequest')->name('payout.request');
        });
        Route::controller(LogManagerController::class)->prefix('log-manager')->name('log.manager.')->group(function() {
            Route::get('/login-session','loginSession')->name('login.session');
            Route::get('/api-logs','apiLogs')->name('api.logs');
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
            Route::get('manage-service','manageService')->name('manage.service');
            Route::get('setting','manageSetting')->name('setting');
        });

        //AEPS Route
        Route::controller(AepsController::class)->group(function(){
            Route::get('aeps-system','aepsServices')->name('aeps.system');
        });

        // Recharge and bill payments Route
        Route::controller(RechargeAndBillPaymentsController::class)->prefix('recharge-and-bill-payments')->name('recharge.and.bill.payments')->group(function(){
            Route::get('/mobile-recharge','mobileRecharge')->name('mobile.recharge');
        });
    });
});
