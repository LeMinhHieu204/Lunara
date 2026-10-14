<?php

namespace App\Http\Controllers;

use App\Models\PaymentEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');
        $parts = collect(explode(',', (string) $signature))->mapWithKeys(function (string $part) { [$key, $value] = array_pad(explode('=', $part, 2), 2, null); return [$key => $value]; });
        $timestamp = $parts->get('t');
        $expected = $timestamp ? hash_hmac('sha256', $timestamp.'.'.$payload, (string) $secret) : '';
        abort_unless($secret && $timestamp && $parts->get('v1') && hash_equals($expected, $parts->get('v1')), 400, 'Invalid webhook signature.');
        $event = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        PaymentEvent::firstOrCreate(['event_id' => $event['id'] ?? sha1($payload)], ['provider' => 'stripe', 'event_type' => $event['type'] ?? 'unknown', 'payload' => $event, 'processed_at' => now()]);
        Log::info('Stripe webhook received', ['event' => $event['id'] ?? null]);
        return response()->json(['received' => true]);
    }
}
