<?php

use App\Http\Controllers\Api\PrintController;
use Illuminate\Support\Facades\Route;
use App\Models\Item;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\DealController;

Route::post('/print-job/{jobId}/acknowledge', [PrintController::class, 'acknowledgePrintJob']);
Route::get('/fetch-job', [PrintController::class, 'fetchPrintJob']);
Route::get('/fetchJob',[PrintController::class,'fetchConPrintJob']);
Route::get('print-orders', [AdminController::class, 'printOrders']);
Route::get('deleteUnpaidPreBookings', [OrderController::class, 'deleteUnpaidPreBookings']);

Route::get('/config', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');

    return 'Config cached successfully!';
});

Route::get('fix-slug', function () {
    $items = Item::orderBy('id')->get();
    $existingSlugs = [];

    foreach ($items as $item) {
        $baseSlug = Str::slug($item->item_name);
        $slug = $baseSlug;
        $i = 1;

        // Ensure uniqueness
        while (
            Item::where('slug', $slug)->where('id', '!=', $item->id)->exists() ||
            in_array($slug, $existingSlugs)
        ) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        // Only update if slug actually changed
        if ($item->slug !== $slug) {
            $item->slug = $slug;
            $item->save();
            $existingSlugs[] = $slug;
        }
    }

    return redirect()->back()->with('success', trans('messages.success') . ' - Slugs fixed.');
});

Route::get('branches', [SiteController::class, 'branches']);
Route::get('home-items', [SiteController::class, 'homeItems']);
Route::get('categories', [SiteController::class, 'categories']);
Route::get('category-items/{slug}', [SiteController::class, 'categoryItems']);
Route::get('item-details/{slug}', [SiteController::class, 'ItemDetails']);
Route::get('pizza-item-details/{slug}', [SiteController::class, 'pizzadetails']);
Route::get('deals', [DealController::class, 'deals']);
Route::get('/show-deal-item/{slug}', [DealController::class, 'showDealitem']);
Route::get('deal-items/{dealId}', [DealController::class, 'dealItems']);

