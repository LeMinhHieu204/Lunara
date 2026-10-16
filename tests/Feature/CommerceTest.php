<?php

namespace Tests\Feature;

use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommerceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
    }

    public function test_guest_can_add_to_cart_and_authenticated_checkout_reserves_inventory(): void
    {
        $variant = ProductVariant::with('inventory')->firstOrFail();
        $user = User::factory()->create(['role' => 'customer']);
        $this->actingAs($user);
        $this->post('/cart/items', ['variant_id' => $variant->id, 'quantity' => 2])->assertRedirect();
        $this->assertDatabaseHas('cart_items', ['product_variant_id' => $variant->id, 'quantity' => 2]);
        $this->post('/checkout', ['email' => $user->email, 'first_name' => 'Demo', 'last_name' => 'Customer', 'line_1' => '1 Lunara Way', 'city' => 'New York', 'postal_code' => '10001', 'country' => 'US'])->assertRedirect();
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('inventories', ['product_variant_id' => $variant->id, 'stock_reserved' => 2]);
    }

    public function test_customer_cannot_view_another_customers_checkout_success(): void
    {
        $owner = User::factory()->create(['role' => 'customer']);
        $otherCustomer = User::factory()->create(['role' => 'customer']);
        $order = Order::create([
            'user_id' => $owner->id,
            'order_number' => 'LUN-AUTH-001',
            'status' => 'pending',
            'payment_status' => 'pending',
            'fulfillment_status' => 'unfulfilled',
            'contact_email' => $owner->email,
            'subtotal' => 10,
            'shipping_total' => 5,
            'discount_total' => 0,
            'tax_total' => 0,
            'total' => 15,
            'shipping_address' => ['line_1' => '1 Lunara Way'],
        ]);

        $this->actingAs($otherCustomer)->get(route('checkout.success', $order))->assertForbidden();
        $this->actingAs($owner)->get(route('checkout.success', $order))->assertOk();
        $this->actingAs(User::factory()->create(['role' => 'admin']))->get(route('checkout.success', $order))->assertOk();
    }

    public function test_shop_filters_by_price_variant_attributes_and_stock(): void
    {
        $available = ProductVariant::with(['product', 'inventory'])->firstOrFail();
        $available->update(['color' => 'Midnight', 'size' => 'S']);
        $available->product->update(['price' => 35]);
        $available->inventory->update(['stock_on_hand' => 8, 'stock_reserved' => 1]);

        $unavailable = ProductVariant::with(['product', 'inventory'])->skip(1)->firstOrFail();
        $unavailable->update(['color' => 'Midnight', 'size' => 'S']);
        $unavailable->product->update(['price' => 35]);
        $unavailable->inventory->update(['stock_on_hand' => 0, 'stock_reserved' => 0]);

        $this->get(route('shop', [
            'min_price' => 30,
            'max_price' => 40,
            'colors' => ['Midnight'],
            'sizes' => ['S'],
            'availability' => 'in_stock',
        ]))->assertOk()->assertSee($available->product->name)->assertDontSee($unavailable->product->name);

        $this->get(route('shop', [
            'colors' => ['Midnight'],
            'sizes' => ['S'],
            'availability' => 'out_of_stock',
        ]))->assertOk()->assertSee($unavailable->product->name)->assertDontSee($available->product->name);

        $this->get(route('shop', ['max_price' => 0]))
            ->assertOk()
            ->assertDontSee($available->product->name)
            ->assertDontSee($unavailable->product->name);
    }

    public function test_signed_stripe_webhook_transitions_payment_and_is_replay_safe(): void
    {
        config(['services.stripe.webhook_secret' => 'lunara-test-secret']);
        $owner = User::factory()->create(['role' => 'customer']);
        $order = Order::create(['user_id' => $owner->id, 'order_number' => 'LUN-PAY-001', 'status' => 'pending', 'payment_status' => 'pending', 'fulfillment_status' => 'unfulfilled', 'contact_email' => $owner->email, 'subtotal' => 10, 'shipping_total' => 5, 'discount_total' => 0, 'tax_total' => 0, 'total' => 15, 'shipping_address' => ['line_1' => '1 Lunara Way']]);
        Payment::create(['order_id' => $order->id, 'provider' => 'stripe', 'status' => 'pending', 'amount' => 15]);
        $event = ['id' => 'evt_lunara_paid_001', 'type' => 'checkout.session.completed', 'data' => ['object' => ['id' => 'cs_lunara_001', 'payment_intent' => 'pi_lunara_001', 'amount_total' => 1500, 'currency' => 'usd', 'payment_status' => 'paid', 'metadata' => ['order_number' => $order->order_number]]]];

        $this->postSignedWebhook($event)->assertOk()->assertJson(['received' => true, 'processed' => true, 'status' => 'paid']);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'processing', 'payment_status' => 'paid']);
        $this->assertDatabaseHas('payments', ['order_id' => $order->id, 'provider_reference' => 'pi_lunara_001', 'status' => 'paid']);
        $this->postSignedWebhook($event)->assertOk()->assertJson(['received' => true, 'duplicate' => true, 'processed' => false]);
        $this->assertDatabaseCount('payment_events', 1);
    }

    public function test_expired_stripe_checkout_fails_payment_and_releases_reserved_stock(): void
    {
        config(['services.stripe.webhook_secret' => 'lunara-test-secret']);
        $owner = User::factory()->create(['role' => 'customer']);
        $variant = ProductVariant::with('product', 'inventory')->firstOrFail();
        $variant->inventory->update(['stock_reserved' => 2]);
        $order = Order::create(['user_id' => $owner->id, 'order_number' => 'LUN-PAY-002', 'status' => 'pending', 'payment_status' => 'pending', 'fulfillment_status' => 'unfulfilled', 'contact_email' => $owner->email, 'subtotal' => 10, 'shipping_total' => 5, 'discount_total' => 0, 'tax_total' => 0, 'total' => 15, 'shipping_address' => ['line_1' => '1 Lunara Way']]);
        $order->items()->create(['product_variant_id' => $variant->id, 'product_name' => $variant->product->name, 'sku' => $variant->sku, 'unit_price' => 5, 'quantity' => 2, 'line_total' => 10]);
        Payment::create(['order_id' => $order->id, 'provider' => 'stripe', 'status' => 'pending', 'amount' => 15]);
        $event = ['id' => 'evt_lunara_expired_001', 'type' => 'checkout.session.expired', 'data' => ['object' => ['id' => 'cs_lunara_expired', 'metadata' => ['order_number' => $order->order_number]]]];

        $this->postSignedWebhook($event)->assertOk()->assertJson(['received' => true, 'processed' => true, 'status' => 'failed']);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'cancelled', 'payment_status' => 'failed']);
        $this->assertDatabaseHas('payments', ['order_id' => $order->id, 'status' => 'failed']);
        $this->assertDatabaseHas('inventories', ['id' => $variant->inventory->id, 'stock_reserved' => 0]);
    }

    private function postSignedWebhook(array $event)
    {
        $payload = json_encode($event, JSON_THROW_ON_ERROR);
        $timestamp = now()->timestamp;
        $signature = 't='.$timestamp.',v1='.hash_hmac('sha256', $timestamp.'.'.$payload, 'lunara-test-secret');
        return $this->call('POST', route('stripe.webhook'), [], [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_STRIPE_SIGNATURE' => $signature], $payload);
    }
}
