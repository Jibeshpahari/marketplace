<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    // =======================  ADMIN ============================
    // Route::get('/', 'adminLoginView');
    Route::get('/', function() {
        return view('admin.layout.demo');
    });
});
