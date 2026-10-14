<?php

namespace Tests\Feature;

use App\Models\ProductVariant;
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
}
