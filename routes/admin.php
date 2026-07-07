<?php

use App\Http\Controllers\Admin\SiteSettingsController;
use Illuminate\Support\Facades\Route;

// Prefix & name decleared in app.php as "admin"

Route::controller(SiteSettingsController::class)->prefix('setting')->name('setting.')->group(function () {
    Route::get('site-settings', 'index')->name('site-settings');
    Route::post('/settings/site-identity', 'storeSiteSettings')->name('site-setting.store');
    // Route::put('/settings/site-identity/{setting}', 'updateSiteIdentity')->name('site-identity.update');
});