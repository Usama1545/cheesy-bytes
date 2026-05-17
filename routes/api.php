<?php

use App\Http\Controllers\Api\PrintController;
use Illuminate\Support\Facades\Route;
use App\Models\Item;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\DealController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\UserController;

Route::post('/print-job/{jobId}/acknowledge', [PrintController::class, 'acknowledgePrintJob']);
Route::get('/fetch-job', [PrintController::class, 'fetchPrintJob']);
Route::get('/fetchJob',[PrintController::class,'fetchConPrintJob']);
Route::get('print-orders', [AdminController::class, 'printOrders']);
Route::get('deleteUnpaidPreBookings', [OrderController::class, 'deleteUnpaidPreBookings']);
Route::get('refund-policy', [SiteController::class, 'refundpolicy']);
Route::get('about-us', [SiteController::class, 'aboutus']);
Route::get('privacy-policy', [SiteController::class, 'privacypolicy']); 
Route::get('terms-conditions', [SiteController::class, 'termsconditions']); 

Route::get('/config', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');

    return 'Config cached successfully!';
});

Route::get('branches', [SiteController::class, 'branches']);
Route::get('branch/time', [SiteController::class, 'brancheTime']);
Route::get('branch/change', [SiteController::class, 'branchChange']);
Route::get('sliders', [SiteController::class, 'sliders']);
Route::get('home-items', [SiteController::class, 'homeItems']);

Route::get('categories', [SiteController::class, 'categories']);
Route::get('categories-products', [SiteController::class, 'categoriesWithProducts']);
Route::get('category-items/{slug}', [SiteController::class, 'categoryItems']);
Route::get('item-details/{slug}', [SiteController::class, 'ItemDetails']);
Route::get('pizza-item-details/{slug}', [SiteController::class, 'pizzadetails']);
Route::get('deals', [DealController::class, 'deals']);
Route::get('show-deal-item/{slug}', [DealController::class, 'showDealitem']);
Route::get('deal-items/{dealId}', [DealController::class, 'dealItems']);

// Public User Routes (No Authentication Required)
Route::post('/register', [UserController::class, 'create']);
Route::post('/verify-otp', [UserController::class, 'verifyotp']);
Route::post('/resend-otp', [UserController::class, 'resendotp']);
Route::post('/login', [UserController::class, 'checklogin']);
Route::post('/forgot-password', [UserController::class, 'sendpass']);
Route::post('add-to-cart', [CartController::class, 'addToCart']);
Route::post('add-pizza-cart', [CartController::class, 'addPizzaToCart']);
Route::get('get-cart-items', [CartController::class, 'index']);
Route::post('update-cart-item', [CartController::class, 'qtyupdate']);
Route::post('remove-cart-item', [CartController::class, 'removeCartItem']);
Route::get('checkout', [CheckoutController::class, 'index']);
Route::post('checkout/placeorder', [CheckoutController::class, 'placeOrder']);
Route::get('checkout/paymentSuccess/{order_id}', [CheckoutController::class, 'paymentSuccess']);
Route::post('timeslot', [CheckoutController::class, 'timeslot']);

// Protected User Routes (Authentication Required)
// Using auth:sanctum for token-based API authentication
Route::middleware(['auth:sanctum'])->group(function () {
Route::post('registerDeviceToken', [UserController::class, 'storeToken']);
Route::get('removeDeviceToken', [UserController::class, 'removeToken']);
Route::get('orders', [UserController::class, 'getOrders']);
Route::get('favoriteItems', [FavoriteController::class, 'index']);
Route::post('managefavorite', [FavoriteController::class, 'toggle']);
Route::get('/profile', [UserController::class, 'getProfile']);
Route::post('/profile/update', [UserController::class, 'editprofile']);
Route::get('/profile/send-email-status', [UserController::class, 'send_email_status']);
Route::get('/refer-earn', [UserController::class, 'referearn']);
Route::post('/changepassword', [UserController::class, 'updatepassword']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('user/delete', [UserController::class, 'deleteAccount']);
Route::post('order/reorder/{orderId}', [CheckoutController::class, 'reOrder']);
});


