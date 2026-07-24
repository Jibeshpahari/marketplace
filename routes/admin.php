<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SiteSettingsController;
use Illuminate\Support\Facades\Route;

// Prefix & name decleared in app.php as "admin"

Route::controller(ProductController::class)->prefix('products')->name('products.')->group( function () {
    Route::get('/', 'index')->name('index');
});

Route::controller(SiteSettingsController::class)->prefix('settings')->name('settings.')->group(function () {
    Route::get('site-settings', 'index')->name('site-settings');
    Route::post('/settings/site-identity', 'storeSiteSettings')->name('site-setting.store');
    // Route::put('/settings/site-identity/{setting}', 'updateSiteIdentity')->name('site-identity.update');
});