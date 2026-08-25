<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SiteSettingsController;
use Illuminate\Support\Facades\Route;

// Prefix & name decleared in app.php as "admin"
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

Route::controller(ProductController::class)->prefix('products')->name('products.')->group( function () {
    Route::get('/', 'index')->name('index');
    Route::get('/add', 'add')->name('add');
    Route::get('/edit/{product}', 'edit')->name('edit');
    Route::post('/save/{product?}', 'save')->name('save');
    Route::get('/delete/{category}', 'delete')->name('delete');
    Route::post('/toggle-status', 'toggleStatus')->name('toggleStatus');
});

Route::controller(CategoryController::class)->prefix('product/categories')->name('categories.')->group( function() {
    Route::get('/', 'index')->name('index');
    Route::get('/add', 'add')->name('add');
    Route::get('/edit/{category}', 'edit')->name('edit');
    Route::post('/save/{category?}', 'save')->name('save');
    Route::get('/delete/{category}', 'delete')->name('delete');
    Route::post('/toggle-status', 'toggleStatus')->name('toggleStatus');
    Route::get('/{category}/subcategories', 'subcategories')->name('subcategories');
});

Route::controller(SiteSettingsController::class)->prefix('settings')->name('settings.')->group(function () {
    Route::get('site-settings', 'index')->name('site-settings');
    Route::post('/settings/site-identity', 'storeSiteSettings')->name('site-setting.store');
    // Route::put('/settings/site-identity/{setting}', 'updateSiteIdentity')->name('site-identity.update');
});