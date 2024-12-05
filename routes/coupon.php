<?php

use App\Http\Controllers\addons\PromocodeController;
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
        // promocode
        Route::get('promocode', [PromocodeController::class, 'index']);
        Route::get('promocode/add', [PromocodeController::class, 'add']);
        Route::post('promocode/store', [PromocodeController::class, 'store']);
        Route::get('promocode-{id}', [PromocodeController::class, 'show']);
        Route::post('promocode/update-{id}', [PromocodeController::class, 'update']);
        Route::post('promocode/status', [PromocodeController::class, 'status']);
        Route::post('promocode/delete', [PromocodeController::class, 'destroy']);
        Route::post('promocode/reorder_promocode', [PromocodeController::class, 'reorder_promocode']);
    });
});
