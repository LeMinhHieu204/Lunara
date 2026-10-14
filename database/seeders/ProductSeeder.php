<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    private array $assets = [
        '/assets/lunara/linen-shirt.png',
        '/assets/lunara/tote-bag.png',
        '/assets/lunara/white-sneakers.png',
        '/assets/lunara/knit-sweater.png',
        '/assets/lunara/perfume.png',
        '/assets/lunara/sunglasses.png',
        '/assets/lunara/tote-bag.png',
        '/assets/lunara/sunglasses.png',
        '/assets/lunara/linen-shirt.png',
        '/assets/lunara/knit-sweater.png',
        '/assets/lunara/baseball-cap.png',
        '/assets/lunara/serum.png',
        '/assets/lunara/linen-shirt.png',
        '/assets/lunara/knit-sweater.png',
        '/assets/lunara/linen-shirt.png',
        '/assets/lunara/tote-bag.png',
        '/assets/lunara/linen-shirt.png',
        '/assets/lunara/baseball-cap.png',
        '/assets/lunara/linen-shirt.png',
        '/assets/lunara/knit-sweater.png',
        '/assets/lunara/linen-shirt.png',
        '/assets/lunara/linen-shirt.png',
        '/assets/lunara/serum.png',
        '/assets/lunara/perfume.png',
    ];

    public function run(): void
    {
        $categoryIds = Category::pluck('id', 'slug');
        $curated = [
            ['Linen Oversize Shirt','clothing',49.99,null,4.8,128,true], ['Minimal Tote Bag','bags',59.99,null,4.7,96,true], ['Classic White Sneakers','shoes',69.99,79.99,4.9,215,true], ['Knit Sweater','clothing',44.99,null,4.8,112,true], ['Eau de Parfum','beauty',39.99,null,4.7,67,true], ['Sunglasses','accessories',29.99,null,4.8,87,false], ['Hydrating Serum','beauty',24.99,null,4.6,67,false], ['Classic Baseball Cap','hats',19.99,null,4.6,45,false], ['Ribbed Cardigan','clothing',54.99,null,4.7,75,false], ['Satin Slip Dress','clothing',59.99,69.99,4.8,98,false], ['Shoulder Bag','bags',49.99,null,4.6,60,false], ['Scented Candle','beauty',19.99,null,4.8,40,false], ['Soft Tailored Blazer','clothing',89.99,109.99,4.8,42,false], ['Leather Crossbody','bags',74.99,null,4.7,51,false], ['Everyday Loafer','shoes',79.99,null,4.6,63,false], ['Golden Hoop Earrings','accessories',26.99,null,4.8,38,false], ['Summer Cotton Dress','clothing',64.99,null,4.7,28,false], ['Woven Sun Hat','hats',32.99,null,4.6,22,false], ['Daily Tank','clothing',24.99,null,4.5,31,false], ['Fine Merino Pullover','clothing',72.99,null,4.7,29,false],
        ];
        foreach ($curated as $index => [$name, $category, $price, $compare, $rating, $reviews, $new]) $this->createProduct($categoryIds[$category], $name, $category, $price, $compare, $rating, $reviews, $new, $this->assets[$index % count($this->assets)], $index + 1);

        $names = ['Relaxed Cotton Tee','Tailored Wide Leg Trouser','Soft Rib Tank','Fine Merino Pullover','Boxy Denim Jacket','Everyday Linen Pant','Canvas Market Tote','Structured Mini Bag','Soft Hobo Bag','Slim Leather Belt','Textured Shoulder Bag','Canvas Slip-On','Quiet Runner Sneaker','Soft Leather Sandal','Minimal Mule','Slim Watch','Silk Scarf','Sculptural Hair Clip','Everyday Studs','Pearl Drop Earrings','Barrier Cream','Everyday Hand Balm','Soft Cleansing Oil','Quiet Room Spray','Nourishing Lip Oil','Washed Cotton Cap','Wool Blend Beanie','Linen Bucket Hat'];
        $categories = ['clothing','clothing','clothing','clothing','clothing','clothing','bags','bags','bags','accessories','bags','shoes','shoes','shoes','shoes','accessories','accessories','accessories','accessories','accessories','beauty','beauty','beauty','beauty','beauty','hats','hats','hats'];
        for ($i = 0; $i < 100; $i++) {
            $nameIndex = $i % count($names); $name = $names[$nameIndex].' '.(intdiv($i, count($names)) + 1); $price = 18 + (($i * 13) % 83) + .99; $onSale = $i % 7 === 0;
            $this->createProduct($categoryIds[$categories[$nameIndex]], $name, $categories[$nameIndex], $price, $onSale ? $price + 15 : null, 4.3 + (($i % 6) * .1), 12 + (($i * 17) % 146), $i % 3 === 0, $this->assets[($i + 4) % count($this->assets)], 21 + $i);
        }
    }

    private function createProduct(int $categoryId, string $name, string $category, float $price, ?float $compare, float $rating, int $reviews, bool $new, string $image, int $number): void
    {
        $slug = Str::slug($name).'-'.str_pad((string) $number, 3, '0', STR_PAD_LEFT);
        $product = Product::updateOrCreate(['sku' => 'LUN-'.$number], ['category_id' => $categoryId, 'name' => $name, 'slug' => $slug, 'description' => 'A considered Lunara essential with an easy silhouette, quiet details and everyday versatility.', 'price' => $price, 'compare_at_price' => $compare, 'material' => 'Selected natural and recycled fibers', 'status' => 'published', 'featured' => $number <= 5, 'new_arrival' => $new, 'on_sale' => (bool) $compare, 'rating' => $rating, 'review_count' => $reviews]);
        $product->images()->updateOrCreate(['image_url' => $image], ['alt_text' => $name, 'is_primary' => true, 'sort_order' => 0]);
        $variant = $product->variants()->updateOrCreate(['sku' => 'LUN-'.$number.'-OS'], ['size' => in_array($category, ['clothing','shoes']) ? 'M' : 'One size', 'color' => 'Warm Taupe', 'price' => $price, 'is_default' => true]);
        $variant->inventory()->updateOrCreate([], ['stock_on_hand' => 20, 'stock_reserved' => 0]);
    }
}
