<?php

namespace Tests\Feature;

use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
    }

    public function test_homepage_and_catalog_are_database_backed(): void
    {
        $this->get('/')->assertOk()->assertSee('Simplicity')->assertSee('Linen Oversize Shirt');
        $this->get('/shop')->assertOk()->assertSee('Showing 1–12 of 120 results');
        $this->get('/category/bags')->assertOk()->assertSee('Minimal Tote Bag');
        $this->get('/products/linen-oversize-shirt-001')->assertOk()->assertSee('Linen Oversize Shirt');
    }
}
