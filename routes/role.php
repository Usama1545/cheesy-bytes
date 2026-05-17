<?php

use App\Http\Controllers\addons\RolesController;
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
        // roles
        Route::get('roles', [RolesController::class, 'index']);
        Route::get('roles/add', [RolesController::class, 'add']);
        Route::post('roles/store', [RolesController::class, 'store']);
        Route::post('roles/status', [RolesController::class, 'status']);
        Route::get('roles-{id}', [RolesController::class, 'show']);
        Route::post('roles/update-{id}', [RolesController::class, 'update']);
    });
});
