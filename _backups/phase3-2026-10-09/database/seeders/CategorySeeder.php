<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Clothing', 'slug' => 'clothing', 'image_url' => 'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?auto=format&fit=crop&w=800&q=86'],
            ['name' => 'Bags', 'slug' => 'bags', 'image_url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=86'],
            ['name' => 'Shoes', 'slug' => 'shoes', 'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=86'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'image_url' => 'https://images.unsplash.com/photo-1523779917675-b6ed3a42a561?auto=format&fit=crop&w=800&q=86'],
            ['name' => 'Beauty', 'slug' => 'beauty', 'image_url' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?auto=format&fit=crop&w=800&q=86'],
            ['name' => 'Hats', 'slug' => 'hats', 'image_url' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=800&q=86'],
        ];
        foreach ($categories as $index => $category) Category::updateOrCreate(['slug' => $category['slug']], $category + ['sort_order' => $index]);
    }
}
