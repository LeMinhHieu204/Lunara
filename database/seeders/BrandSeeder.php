<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Lunara Studio', 'Atelier Edit', 'Common Thread'] as $name) Brand::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'description' => 'Sample catalog brand content, replaceable from Admin.', 'is_active' => true]);
    }
}
