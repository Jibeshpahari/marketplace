<?php

use App\Http\Controllers\Admin\SiteSettingsController;
use Illuminate\Support\Facades\Route;

// Prefix & name decleared in app.php as "admin"

Route::controller(SiteSettingsController::class)->prefix('setting')->name('setting.')->group(function () {
    Route::get('site-settings', 'index')->name('site-settings');
});