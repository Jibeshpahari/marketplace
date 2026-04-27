<?php

use Illuminate\Support\Facades\Route;

// Show the payment page
Route::get('/payment', function () {
    return view('payment');
})->name('payment.index');

// Process the payment
Route::post('/payment/process', function () {
    // Controller will handle this
})->name('payment.process');

// Payment success page
Route::get('/payment/success', function () {
    return view('payment.success');
})->name('payment.success');

// Payment failed page
Route::get('/payment/failed', function () {
    return view('payment.failed');
})->name('payment.failed');

// // Stripe webhook
// Route::post('/payment/webhook', function () {
//     // Controller will handle this
// })->name('payment.webhook')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);