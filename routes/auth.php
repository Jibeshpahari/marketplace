<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    // =======================  ADMIN ============================
    Route::get('admin/login', 'adminLoginView')->name('admin.login.view');
    Route::post('admin/login', 'adminLoginView')->name('admin.login.post');
});