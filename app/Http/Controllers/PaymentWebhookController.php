<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function __invoke(Request $request, PaymentService $payments)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');
        $parts = collect(explode(',', (string) $signature))->mapWithKeys(function (string $part) { [$key, $value] = array_pad(explode('=', trim($part), 2), 2, null); return [$key => $value]; });
        $timestamp = (int) $parts->get('t');
        $expected = $timestamp ? hash_hmac('sha256', $timestamp.'.'.$payload, (string) $secret) : '';
        abort_unless($secret && $timestamp && abs(now()->timestamp - $timestamp) <= 300 && $parts->get('v1') && hash_equals($expected, $parts->get('v1')), 400, 'Invalid webhook signature.');
        $event = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        return response()->json(['received' => true] + $payments->reconcileStripeEvent($event));
    }
}
