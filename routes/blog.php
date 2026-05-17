<?php

use App\Http\Controllers\addons\BlogController;
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
        Route::get('blogs', [BlogController::class, 'index']);
        Route::get('blogs/add', [BlogController::class, 'add']);
        Route::post('blogs/store', [BlogController::class, 'store']);
        Route::get('blogs-{id}', [BlogController::class, 'show']);
        Route::post('blogs/update-{id}', [BlogController::class, 'update']);
        Route::post('blogs/delete', [BlogController::class, 'delete']);
        Route::post('blogs/reorder_blog', [BlogController::class, 'reorder_blog']);
    });
});


Route::group(['namespace' => 'front', 'middleware' => 'MaintenanceMiddleware'], function () {
    Route::get('/blogs', [BlogController::class, 'blogs'])->name('blogs');
    Route::get('/blogs-{slug}', [BlogController::class, 'showblog'])->name('blogdetails');
});
