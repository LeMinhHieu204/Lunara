<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class VisualAssetSeeder extends Seeder
{
    private const ASSETS = [
        'hero' => '/assets/lunara/hero-rack.png',
        'linen' => '/assets/lunara/linen-shirt.png',
        'bag' => '/assets/lunara/tote-bag.png',
        'shoes' => '/assets/lunara/white-sneakers.png',
        'sweater' => '/assets/lunara/knit-sweater.png',
        'perfume' => '/assets/lunara/perfume.png',
        'sunglasses' => '/assets/lunara/sunglasses.png',
        'serum' => '/assets/lunara/serum.png',
        'cap' => '/assets/lunara/baseball-cap.png',
    ];

    public function run(): void
    {
        foreach ([
            'clothing' => self::ASSETS['linen'],
            'bags' => self::ASSETS['bag'],
            'shoes' => self::ASSETS['shoes'],
            'accessories' => self::ASSETS['sunglasses'],
            'beauty' => self::ASSETS['serum'],
            'hats' => self::ASSETS['cap'],
        ] as $slug => $image) {
            Category::where('slug', $slug)->update(['image_url' => $image]);
        }

        Product::with('category')->get()->each(function (Product $product): void {
            $image = $this->imageFor($product);
            $product->images()->updateOrCreate(
                ['is_primary' => true],
                ['image_url' => $image, 'alt_text' => $product->name, 'sort_order' => 0]
            );
        });
    }

    private function imageFor(Product $product): string
    {
        return match (true) {
            str_contains($product->name, 'Linen Oversize Shirt') => self::ASSETS['linen'],
            str_contains($product->name, 'Minimal Tote Bag') => self::ASSETS['bag'],
            str_contains($product->name, 'Classic White Sneakers') => self::ASSETS['shoes'],
            str_contains($product->name, 'Knit Sweater') => self::ASSETS['sweater'],
            str_contains($product->name, 'Eau de Parfum') => self::ASSETS['perfume'],
            str_contains($product->name, 'Sunglasses') => self::ASSETS['sunglasses'],
            str_contains($product->name, 'Hydrating Serum') => self::ASSETS['serum'],
            str_contains($product->name, 'Classic Baseball Cap') => self::ASSETS['cap'],
            $product->category?->slug === 'clothing' && str_contains($product->name, 'Sweater') => self::ASSETS['sweater'],
            $product->category?->slug === 'clothing' => self::ASSETS['linen'],
            $product->category?->slug === 'bags' => self::ASSETS['bag'],
            $product->category?->slug === 'shoes' => self::ASSETS['shoes'],
            $product->category?->slug === 'accessories' => self::ASSETS['sunglasses'],
            $product->category?->slug === 'beauty' && preg_match('/serum|cream|balm|oil|clean|room/i', $product->name) === 1 => self::ASSETS['serum'],
            $product->category?->slug === 'beauty' => self::ASSETS['perfume'],
            $product->category?->slug === 'hats' => self::ASSETS['cap'],
            default => self::ASSETS['hero'],
        };
    }
}
