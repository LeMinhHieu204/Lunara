<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Database\Seeders\BlogCategorySeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CouponSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase3Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([CategorySeeder::class, ProductSeeder::class, BlogCategorySeeder::class, CouponSeeder::class]);
    }

    public function test_admin_can_create_categories_coupons_and_manage_inventory(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $this->post('/admin/categories', ['name' => 'Test Edit', 'slug' => 'test-edit'])->assertRedirect();
        $this->assertDatabaseHas('categories', ['slug' => 'test-edit']);
        $this->post('/admin/coupons', ['code' => 'SPRING15', 'type' => 'percent', 'value' => 15])->assertRedirect();
        $this->assertDatabaseHas('coupons', ['code' => 'SPRING15']);
        $inventory = ProductVariant::firstOrFail()->inventory;
        $this->patch('/admin/inventory/'.$inventory->id, ['stock_on_hand' => 30, 'stock_reserved' => 0])->assertRedirect();
        $this->assertDatabaseHas('inventories', ['id' => $inventory->id, 'stock_on_hand' => 30]);
    }

    public function test_customer_wishlist_profile_and_newsletter_are_persistent(): void
    {
        $customer = User::factory()->create(['role' => 'customer']); $product = Product::firstOrFail(); $this->actingAs($customer);
        $this->post('/wishlist/'.$product->id)->assertRedirect();
        $this->assertDatabaseHas('wishlists', ['user_id' => $customer->id, 'product_id' => $product->id]);
        $this->patch('/account/profile', ['name' => 'Updated Customer', 'phone' => '555-0100'])->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $customer->id, 'name' => 'Updated Customer']);
        $this->post('/newsletter', ['email' => 'qa@lunara.test'])->assertRedirect();
        $this->assertDatabaseHas('newsletter_subscribers', ['email' => 'qa@lunara.test', 'status' => 'subscribed']);
    }

    public function test_coupon_is_applied_and_redemption_is_recorded_during_checkout(): void
    {
        $customer = User::factory()->create(['role' => 'customer']); $variant = ProductVariant::firstOrFail(); $this->actingAs($customer);
        $this->post('/cart/items', ['variant_id' => $variant->id, 'quantity' => 1]);
        $this->post('/checkout', ['email' => $customer->email, 'first_name' => 'QA', 'last_name' => 'Customer', 'line_1' => '1 Lunara Way', 'city' => 'New York', 'postal_code' => '10001', 'country' => 'US', 'coupon_code' => 'WELCOME10'])->assertRedirect();
        $this->assertDatabaseHas('orders', ['discount_total' => '5.00']);
        $this->assertDatabaseHas('coupon_redemptions', ['user_id' => $customer->id]);
    }

    public function test_customer_cannot_access_admin_and_blog_routes_are_live(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $this->actingAs($customer)->get('/admin')->assertForbidden();
        $this->get('/blog')->assertOk();
    }
}
