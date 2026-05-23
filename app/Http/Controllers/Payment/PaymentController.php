<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function process(Request $request)
    {
        // Set Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Static test data for now
        $amount      = $request->get('amount') * 100;        // Convert ₹ to paise
        $currency    = 'INR';
        $productName = 'Test Product';
        $description = 'This is a test payment';

        // Create Stripe Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => $currency,
                    'unit_amount'  => $amount,
                    'product_data' => [
                        'name'        => $productName,
                        'description' => $description,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('payment.failed'),
        ]);

        // Redirect user to Stripe's hosted payment page
        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // Grab the session ID Stripe sends back
        $sessionId = $request->get('session_id');

        return view('payment-success', [
            'sessionId' => $sessionId
        ]);
    }

    public function cancel()
    {
        return view('payment-failed');
    }
}