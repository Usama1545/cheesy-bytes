<?php

use App\Http\Controllers\addons\StoreReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::group(['middleware' => 'AdminAuth'], function () {
        Route::get('store-review', [StoreReviewController::class, 'index']);
        Route::get('store-review/add', [StoreReviewController::class, 'add']);
        Route::post('store-review/store', [StoreReviewController::class, 'store']);
        Route::get('store-review-{id}', [StoreReviewController::class, 'show']);
        Route::post('store-review/update-{id}', [StoreReviewController::class, 'update']);
        Route::post('store-review/destroy', [StoreReviewController::class, 'destroy']);
        Route::post('store-review/reorder_ratting', [StoreReviewController::class, 'reorder_ratting']);
    });
});
