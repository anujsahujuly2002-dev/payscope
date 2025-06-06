<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WebHookController;

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

Route::get('/',function (){
    return to_route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function(){
   /*  Route::match(['get', 'post'], 'web-hook-recived-payment-in-razorapy', [App\Http\Controllers\Api\QRPaymentCollectionController::class,'webhookRecivedPaymentInRazorapy'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::match(['get', 'post'], 'web-hook-order-paid-razorpay-nikhil', [App\Http\Controllers\Api\QRPaymentCollectionController::class,'webHookOrderPaidCallBack'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::match(['get', 'post'],'webhookpaynpro',[App\Http\Controllers\Api\FundRequestController::class,'webHookPaynPro'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::match(['get', 'post'],'get-dispute-payment',[DashBoardController::class,'getDisputePayment'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::match(['get', 'post'],'eko-payout-webhook',[DashBoardController::class,'ekoPayoutWebHook'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]); */
    Route::match(['get', 'post'],'phone-pe-callback',[WebHookController::class,'phonePeCallBack'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
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
            Route::get('/settelment','settelment')->name('settelment');
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
            Route::get('/wallet', 'wallet')->name('wallet');
        });

        // Setup Tools Route
        Route::controller(SetupToolsController::class)->prefix('setup')->name('setup.')->group(function(){
            Route::get('/bank','bank')->name('bank');
            Route::get('/opertator-manager','operatorManger')->name('operator.manager');
            Route::get('/benificiary-manage','benificiaryManage')->name('benificiary.manage');
            Route::get('/services','services')->name('services');
        });

        // Fund Manage Route
        Route::controller(FundController::class)->prefix('fund')->name('fund.')->group(function(){
            Route::get('/manual-request','manualRequest')->name('manual.request');
            Route::get('/virtul-request','virtualRequest')->name('virtual.request');
            Route::get('/qr-request','qrRequest')->name('qr.request');
            // Route::get('/qr-collection','qrCollection')->name('qr.collection');
            Route::get('/transaction-history','transactionHistory')->name('transaction.history');
            Route::get('/transfer-return','transfer_return')->name('transfer.return');
        });


        // Payment Collection Route
        Route::controller(PaymentCollectionController::class)->prefix('payment-collection')->name('payment.collection.')->group(function(){
            Route::get('/index','index')->name('index');
            Route::get('/phone-pe-callback','phonePeCallback')->name('phone.callback');

        });

        // Payout Manager Route
        Route::controller(PayoutMangerController::class)->prefix('payout')->name('payout.')->group(function() {
            Route::get('/payout-request','payoutRequest')->name('payout.request');
            Route::get('disputes','disputes')->name('disputes');
        });
        Route::controller(LogManagerController::class)->prefix('log-manager')->name('log.manager.')->group(function() {
            Route::get('/login-session','loginSession')->name('login.session');
            Route::get('/api-logs','apiLogs')->name('api.logs');
            Route::get('/razorpay-api-logs','razorpayapiLogs')->name('razorpay.api.logs');
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

        // Domestic Money Transfer Routes
        Route::controller(DomesticMoneyTransferController::class)->prefix('domestic-money-transfer')->name('domestic.money.transfer.')->group(function(){
            Route::get('/recipient-list','index')->name('recipient.list');
        });


    });
});
