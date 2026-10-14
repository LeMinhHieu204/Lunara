<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_area_requires_role_and_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $customer = User::factory()->create(['role' => 'customer']);
        $this->actingAs($customer)->get('/admin')->assertForbidden();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get('/admin')->assertOk()->assertSee('Admin Dashboard');
    }
}
