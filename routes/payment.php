<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\payment\PaymentController;

Route::get('/payment',          [PaymentController::class, 'index'])  ->name('payment.index');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/success',  [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed',   [PaymentController::class, 'cancel']) ->name('payment.failed');
