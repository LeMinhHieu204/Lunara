<?php

use App\Http\Controllers\PaymentWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/payments/stripe/webhook', PaymentWebhookController::class)->name('stripe.webhook');
