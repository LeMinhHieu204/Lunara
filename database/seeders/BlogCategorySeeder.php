<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ([['name' => 'Style Notes', 'slug' => 'style-notes'], ['name' => 'Materials', 'slug' => 'materials']] as $category) BlogCategory::updateOrCreate(['slug' => $category['slug']], $category);
    }
}
