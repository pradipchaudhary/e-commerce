<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\core\CartController;
use App\Http\Controllers\core\CheckoutController;
use App\Http\Controllers\core\ExcelUploadController;
use App\Http\Controllers\core\OfferController;
use App\Http\Controllers\core\OrderHistoryController;
use App\Http\Controllers\core\UserDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\settimg\ShippingController;
use App\Http\Controllers\setting\CarrierController;
use App\Http\Controllers\setting\ColorController;
use App\Http\Controllers\setting\GradeController;
use App\Http\Controllers\setting\GradeScaleController;
use App\Http\Controllers\setting\InsuranceController;
use App\Http\Controllers\setting\ManufacturerController;
use App\Http\Controllers\setting\ProductController;
use App\Http\Controllers\setting\ShippingMethodController;
use App\Http\Controllers\setting\StatusController;
use App\Http\Controllers\setting\VendorController;
use App\Http\Controllers\setting\WareHouseController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('symlink',function(){
    Artisan::call('storage:link');
});
Route::get('/',[HomeController::class,'home']);
// this is route of authentictaion
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('symlink',function(){ Artisan::call('storage:link');});
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'registerSubmit'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('email-verification', [AuthController::class, 'verify'])->name('verify');
Route::post('email-verification', [AuthController::class, 'verifyEmail'])->name('verifyEmail');
Route::get('account-setup', [AuthController::class, 'accountSetup'])->name('account_setup.view');
Route::post('account-setup', [AuthController::class, 'accountSetupSubmit'])->name('account_setup.submit');
Route::post('forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('reset-password', [AuthController::class, 'resetPasswordSubmit'])->name('resetpassword');

// get all country @MOCKING WITH THIRD PARTY API :)
Route::get('address', function () {
    $response = Http::post('https://app.wesellcellular.com/j_spring_security_check', [
        'j_username' => 'Everestphones@gmail.com',
        'j_password' => 'Anmol999'
    ]);
    $response = Http::get('https://app.wesellcellular.com/api/onboarding/v1/page-rule');
    dd($response->collect());
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('stock-list', [HomeController::class, 'stockList'])->name('stock_list');
    Route::get('get-stock', [HomeController::class, 'returnAllData'])->name('get_stock');
    Route::post('get-stock', [HomeController::class, 'returnAllDataViaPost'])->name('get_stock_post');
    Route::post('add-cart', [CartController::class, 'store'])->name('addToCart');
    Route::post('add-offer', [CartController::class, 'storeOffer'])->name('addOffer');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('change-status-accept/{offer}', [OfferController::class, 'accept'])->name('cart.status.accept');
    Route::get('change-status-reject/{offer}', [OfferController::class, 'reject'])->name('cart.status.reject');
    Route::post('cart-delete', [CartController::class, 'delete'])->name('cart.destroy');
    Route::post('offer-delete', [CartController::class, 'deleteOffer'])->name('offer.destroy');
    Route::post('cart-checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart-increement', [CartController::class, 'addSubtratctQuantity'])->name('cart.increementQuantity');
    Route::post('cart-decreement', [CartController::class, 'addSubtratctQuantity'])->name('cart.decreementQuantity');
    Route::get('checkout/shipping', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout/shipping', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('order-confrimation', [CheckoutController::class, 'orderConfrimation'])->name('checkout.orderConfrimation');
    Route::post('order-confrimation', [CheckoutController::class, 'orderConfrimationSubmit'])->name('checkout.orderConfrimationSubmit');
    Route::get('user-profile', [AuthController::class, 'showProfile'])->name('user.profile');
    Route::get('user-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('user-order-detail/{token}', [UserDashboardController::class, 'detail'])->name('user.dashboard.detail');
    Route::get('offer-view', [UserDashboardController::class, 'offerView'])->name('user.dashboard.offer');
    Route::get('credentials', [UserDashboardController::class, 'passwordChangeView'])->name('user.dashboard.change_password');
    Route::post('credentials', [UserDashboardController::class, 'passwordChange'])->name('user.dashboard.change_password_submit');
    Route::group(['middleware' => 'superadmin'], function () {
        Route::get('home', [HomeController::class, 'index']);
        Route::get('user-approve/{user}', [AuthController::class, 'approve'])->name('user.approve');
        Route::post('product/add-product', [ProductController::class, 'addMore'])->name('stock.add');
        Route::get('stock-log', [StockController::class, 'showStockLog'])->name('stock-log.index');
        Route::get('offer-list', [OfferController::class, 'index'])->name('offer.index'); 
        Route::get('order-detail/{token}', [OrderHistoryController::class, 'viewOrderDetail'])->name('offer.order_detail'); 
        Route::get('get-offer-data', [OfferController::class, 'returnAllOfferData'])->name('offer.data');
        Route::post('offer-status', [OfferController::class, 'reviewOffer'])->name('offer.status');
        Route::get('order-history', [OrderHistoryController::class, 'index'])->name('order_history.index');
        Route::get('order-history-report', [OrderHistoryController::class, 'orderHistoryReport'])->name('order_history.report');
        Route::post('switch-paid-status', [OrderHistoryController::class, 'switchPaidStatus'])->name('order_history.switchPaidStatus');
        Route::post('dispatch-order', [OrderHistoryController::class, 'dispatchOrder'])->name('order_history.dispatch');
        Route::post('switch-deliver-status', [OrderHistoryController::class, 'switchDeliverStatus'])->name('order_history.switchDeliverStatus');
        Route::get('upload-excel', [ExcelUploadController::class, 'index'])->name('upload.excel');
        Route::get('change-esn-status/{esn}', [ExcelUploadController::class, 'changeStatus'])->name('esn.change_status');
        Route::get('filter-by-vendor', [ExcelUploadController::class, 'report'])->name('filter.vendor');
        Route::post('upload-excel', [ExcelUploadController::class, 'store'])->name('upload.excelsubmit');
        Route::resource('stock', StockController::class);
        Route::prefix('setting')->group(function () {
            Route::resource('product', ProductController::class)->only('index', 'store');
            Route::resource('grade', GradeController::class)->only('index', 'store', 'update');
            Route::resource('carrier', CarrierController::class)->only('index', 'store', 'update');
            Route::resource('vendor', VendorController::class)->only('index', 'store', 'update');
            Route::resource('color', ColorController::class)->only('index', 'store', 'update');
            Route::resource('status', StatusController::class)->only('index', 'store', 'update');
            Route::resource('manufacturer', ManufacturerController::class)->only('index', 'store', 'update');
            Route::resource('warehouse', WareHouseController::class)->only('index', 'store', 'update');
            Route::resource('grade-scale', GradeScaleController::class)->only('index', 'create', 'store');
            Route::resource('shipping-method', ShippingMethodController::class)->only('index', 'create', 'store','update');
            Route::get('shipping', [ShippingController::class,'index'])->name('shipping.index');
            Route::post('free-shipping-edit', [ShippingController::class,'freeShippingEdit'])->name('shipping.freeShippingEdit');
            Route::post('shipping', [ShippingController::class,'store'])->name('shipping.store');
            Route::get('insurance', [InsuranceController::class,'index'])->name('insurance.index');
            Route::put('insurance/{insurance}', [InsuranceController::class,'update'])->name('insurance.update');
        });
    });
});
