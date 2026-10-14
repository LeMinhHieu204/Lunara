<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Clothing', 'slug' => 'clothing', 'image_url' => '/assets/lunara/linen-shirt.png'],
            ['name' => 'Bags', 'slug' => 'bags', 'image_url' => '/assets/lunara/tote-bag.png'],
            ['name' => 'Shoes', 'slug' => 'shoes', 'image_url' => '/assets/lunara/white-sneakers.png'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'image_url' => '/assets/lunara/sunglasses.png'],
            ['name' => 'Beauty', 'slug' => 'beauty', 'image_url' => '/assets/lunara/serum.png'],
            ['name' => 'Hats', 'slug' => 'hats', 'image_url' => '/assets/lunara/baseball-cap.png'],
        ];
        foreach ($categories as $index => $category) Category::updateOrCreate(['slug' => $category['slug']], $category + ['sort_order' => $index]);
    }
}
