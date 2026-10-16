<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\PaymentEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentService
{
    public function start(Order $order): string
    {
        $payment = $order->payment()->firstOrFail();
        $secret = config('services.stripe.secret');

        if (! $secret) {
            abort_unless(in_array(app()->environment(), ['local', 'testing'], true), 503, 'A payment provider is not configured.');
            $payment->update(['provider' => 'fake', 'provider_reference' => 'fake_'.$order->id.'_'.Str::lower(Str::random(12)), 'payload' => ['mode' => 'local_simulation']]);
            return route('checkout.success', ['order' => $order]);
        }

        $currency = strtolower($order->currency ?: 'USD');
        $amountCents = (int) round(((float) $order->total) * 100);
        $response = Http::asForm()->withToken($secret)->post('https://api.stripe.com/v1/checkout/sessions', [
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => $order]).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', ['order' => $order]),
            'line_items[0][price_data][currency]' => $currency,
            'line_items[0][price_data][product_data][name]' => 'Lunara order '.$order->order_number,
            'line_items[0][price_data][unit_amount]' => $amountCents,
            'line_items[0][quantity]' => 1,
            'metadata[order_number]' => $order->order_number,
            'metadata[order_id]' => (string) $order->id,
        ]);

        if (! $response->successful() || ! is_string($response->json('url')) || ! is_string($response->json('id'))) {
            throw new \RuntimeException('The payment provider did not create a checkout session.');
        }

        $payment->update([
            'provider' => 'stripe',
            'provider_reference' => $response->json('id'),
            'payload' => ['checkout_session' => $response->json()],
        ]);

        return $response->json('url');
    }

    public function failOrder(Order $order): void
    {
        DB::transaction(function () use ($order): void {
            $locked = Order::query()->with(['items.variant.inventory', 'payment'])->lockForUpdate()->find($order->id);
            if (! $locked || $locked->payment_status === 'paid' || $locked->status === 'cancelled') return;
            $this->releaseReservedStock($locked);
            $locked->payment?->update(['status' => 'failed']);
            $locked->update(['status' => 'cancelled', 'payment_status' => 'failed']);
            OrderStatusHistory::create(['order_id' => $locked->id, 'status' => 'cancelled', 'note' => 'Payment checkout failed or expired.']);
        });
    }

    public function reconcileStripeEvent(array $event): array
    {
        $eventId = $event['id'] ?? null;
        if (! is_string($eventId) || $eventId === '') abort(400, 'Stripe event id is required.');

        return DB::transaction(function () use ($event, $eventId): array {
            $inserted = DB::table('payment_events')->insertOrIgnore([
                'provider' => 'stripe',
                'event_id' => $eventId,
                'event_type' => $event['type'] ?? 'unknown',
                'payload' => json_encode($event, JSON_THROW_ON_ERROR),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if ($inserted === 0) return ['duplicate' => true, 'processed' => false];

            $eventRecord = PaymentEvent::query()->where('event_id', $eventId)->lockForUpdate()->firstOrFail();
            $kind = $this->eventKind($event['type'] ?? '');
            if ($kind === 'ignored') {
                $eventRecord->update(['processed_at' => now()]);
                return ['duplicate' => false, 'processed' => false, 'ignored' => true];
            }

            $details = $this->eventDetails($event);
            $payment = $this->findPayment($details);
            if (! $payment) {
                $eventRecord->update(['processed_at' => now()]);
                return ['duplicate' => false, 'processed' => false, 'unmatched' => true];
            }
            $order = $payment->order()->lockForUpdate()->firstOrFail();

            if (in_array($kind, ['paid', 'pending', 'refunded'], true)) {
                $this->assertAmountAndCurrency($details, $payment, $order, $kind);
            }

            if ($kind === 'paid') {
                if (in_array($payment->status, ['refunded', 'partially_refunded'], true) || in_array($order->status, ['cancelled', 'completed'], true)) abort(409, 'The order is no longer payable.');
                if (($details['payment_status'] ?? null) && $details['payment_status'] !== 'paid') abort(409, 'The checkout session is not marked as paid.');
                $payment->update(['provider' => 'stripe', 'provider_reference' => $details['provider_reference'], 'status' => 'paid', 'payload' => $event]);
                $this->transitionOrder($order, 'processing', 'paid', 'Stripe payment confirmed.');
            } elseif ($kind === 'pending') {
                if (in_array($payment->status, ['paid', 'refunded', 'partially_refunded'], true)) {
                    $eventRecord->update(['processed_at' => now()]);
                    return ['duplicate' => false, 'processed' => false, 'ignored' => true];
                }
                $payment->update(['provider' => 'stripe', 'provider_reference' => $details['provider_reference'], 'status' => 'pending', 'payload' => $event]);
                $order->update(['payment_status' => 'pending']);
            } elseif ($kind === 'failed') {
                if (in_array($payment->status, ['paid', 'refunded', 'partially_refunded'], true)) {
                    $eventRecord->update(['processed_at' => now()]);
                    return ['duplicate' => false, 'processed' => false, 'ignored' => true];
                }
                $payment->update(['provider' => 'stripe', 'provider_reference' => $details['provider_reference'], 'status' => 'failed', 'payload' => $event]);
                if ($order->status !== 'cancelled') {
                    $this->releaseReservedStock($order);
                    $this->transitionOrder($order, 'cancelled', 'failed', 'Stripe payment failed or checkout expired.');
                }
            } else {
                $refundAmount = $details['refund_amount_cents'] ?? $details['amount_cents'];
                $fullRefund = $refundAmount !== null && $refundAmount >= $this->amountInCents($payment->amount);
                $status = $fullRefund ? 'refunded' : 'partially_refunded';
                $payment->update(['provider' => 'stripe', 'provider_reference' => $details['provider_reference'], 'status' => $status, 'payload' => $event]);
                $order->update(['payment_status' => $status]);
            }

            $eventRecord->update(['processed_at' => now()]);
            return ['duplicate' => false, 'processed' => true, 'status' => $kind === 'refunded' ? ($payment->status) : $kind];
        });
    }

    private function eventKind(string $type): string
    {
        return match ($type) {
            'checkout.session.completed', 'checkout.session.async_payment_succeeded', 'payment_intent.succeeded' => 'paid',
            'payment_intent.processing' => 'pending',
            'checkout.session.async_payment_failed', 'payment_intent.payment_failed', 'checkout.session.expired' => 'failed',
            'charge.refunded' => 'refunded',
            default => 'ignored',
        };
    }

    private function eventDetails(array $event): array
    {
        $object = $event['data']['object'] ?? [];
        $metadata = $object['metadata'] ?? [];
        return [
            'order_number' => $metadata['order_number'] ?? $metadata['orderNumber'] ?? null,
            'provider_reference' => $object['payment_intent'] ?? $object['id'] ?? null,
            'amount_cents' => $object['amount_total'] ?? $object['amount_received'] ?? $object['amount'] ?? null,
            'refund_amount_cents' => $object['amount_refunded'] ?? null,
            'currency' => isset($object['currency']) ? strtoupper((string) $object['currency']) : null,
            'payment_status' => $object['payment_status'] ?? null,
        ];
    }

    private function findPayment(array $details): ?Payment
    {
        if (! $details['order_number'] && ! $details['provider_reference']) return null;
        return Payment::query()->where(function ($query) use ($details): void {
            $started = false;
            if ($details['order_number']) {
                $query->whereHas('order', fn ($orderQuery) => $orderQuery->where('order_number', $details['order_number']));
                $started = true;
            }
            if ($details['provider_reference']) {
                $started ? $query->orWhere('provider_reference', $details['provider_reference']) : $query->where('provider_reference', $details['provider_reference']);
            }
        })->lockForUpdate()->first();
    }

    private function assertAmountAndCurrency(array $details, Payment $payment, Order $order, string $kind): void
    {
        $amount = $kind === 'refunded' ? ($details['refund_amount_cents'] ?? $details['amount_cents']) : $details['amount_cents'];
        if (! is_numeric($amount) || (int) $amount !== $amount || (int) $amount <= 0 || ($kind !== 'refunded' && (int) $amount !== $this->amountInCents($payment->amount)) || ($kind === 'refunded' && (int) $amount > $this->amountInCents($payment->amount))) abort(400, 'The provider amount does not match the order payment.');
        if ($details['currency'] && strtoupper($order->currency ?: 'USD') !== $details['currency']) abort(400, 'The provider currency does not match the order payment.');
    }

    private function amountInCents($amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    private function transitionOrder(Order $order, string $status, string $paymentStatus, string $note): void
    {
        $from = $order->status;
        $order->update(['status' => $status, 'payment_status' => $paymentStatus]);
        if ($from !== $status) OrderStatusHistory::create(['order_id' => $order->id, 'status' => $status, 'note' => $note]);
    }

    private function releaseReservedStock(Order $order): void
    {
        foreach ($order->items as $item) {
            $inventoryId = $item->variant?->inventory?->id;
            if (! $inventoryId) continue;
            $inventory = Inventory::query()->lockForUpdate()->find($inventoryId);
            if ($inventory) $inventory->decrement('stock_reserved', min($item->quantity, $inventory->stock_reserved));
        }
    }
}
