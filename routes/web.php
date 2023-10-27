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
            });
        });

        // Setup Tools Route
        Route::controller(SetupToolsController::class)->prefix('setup')->name('setup.')->group(function(){
            Route::get('/bank','bank')->name('bank');
        });

        // Fund Manage Route
        Route::controller(FundController::class)->prefix('fund')->name('fund.')->group(function(){
            Route::get('/manual-request','manualRequest')->name('manual.request');
        });
    });
});