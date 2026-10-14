<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([CategorySeeder::class, BrandSeeder::class, ProductSeeder::class, VisualAssetSeeder::class, BlogCategorySeeder::class, BlogPostSeeder::class, CouponSeeder::class]);
        User::updateOrCreate(['email' => 'admin@lunara.test'], ['name' => 'Lunara Admin', 'password' => 'password', 'role' => 'admin']);
        User::updateOrCreate(['email' => 'customer@lunara.test'], ['name' => 'Demo Customer', 'password' => 'password', 'role' => 'customer']);
    }
}
