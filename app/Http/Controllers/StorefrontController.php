<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function home()
    {
        return view('storefront.home', [
            'categories' => Category::where('is_active', true)->orderBy('sort_order')->get(),
            'arrivals' => Product::with('images')->where('status', 'published')->where('new_arrival', true)->orderByDesc('featured')->orderBy('id')->limit(5)->get(),
        ]);
    }

    public function shop(Request $request)
    {
        $filters = $request->validate([
            'category' => ['nullable', 'string', 'max:100'],
            'q' => ['nullable', 'string', 'max:100'],
            'min_price' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'colors' => ['nullable', 'array', 'max:20'],
            'colors.*' => ['string', 'max:50'],
            'sizes' => ['nullable', 'array', 'max:20'],
            'sizes.*' => ['string', 'max:50'],
            'availability' => ['nullable', 'in:all,in_stock,out_of_stock'],
            'sale' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'in:featured,newest,price-asc,price-desc,rating'],
        ]);

        $query = Product::with(['category', 'images', 'variants.inventory'])->where('status', 'published');
        $category = (string) ($filters['category'] ?? '');
        if ($category) $query->whereHas('category', fn ($builder) => $builder->where('slug', $category));
        if (! empty($filters['q'])) $query->where(fn ($builder) => $builder->where('name', 'like', '%'.$filters['q'].'%')->orWhere('description', 'like', '%'.$filters['q'].'%'));
        if (array_key_exists('min_price', $filters) && $filters['min_price'] !== null && $filters['min_price'] !== '') $query->where('price', '>=', $filters['min_price']);
        if (array_key_exists('max_price', $filters) && $filters['max_price'] !== null && $filters['max_price'] !== '') $query->where('price', '<=', $filters['max_price']);
        if (! empty($filters['colors'])) $query->whereHas('variants', fn ($builder) => $builder->whereIn('color', $filters['colors']));
        if (! empty($filters['sizes'])) $query->whereHas('variants', fn ($builder) => $builder->whereIn('size', $filters['sizes']));
        if (($filters['availability'] ?? null) === 'in_stock') {
            $query->whereHas('variants', fn ($variant) => $variant->whereHas('inventory', fn ($inventory) => $inventory->whereColumn('stock_on_hand', '>', 'stock_reserved')));
        } elseif (($filters['availability'] ?? null) === 'out_of_stock') {
            $query->whereDoesntHave('variants', fn ($variant) => $variant->whereHas('inventory', fn ($inventory) => $inventory->whereColumn('stock_on_hand', '>', 'stock_reserved')));
        }
        if (! empty($filters['sale']) || $request->routeIs('deals')) $query->where('on_sale', true);
        if ($request->routeIs('new-arrivals')) $query->where('new_arrival', true);
        match ($filters['sort'] ?? null) {
            'price-asc' => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'rating' => $query->orderByDesc('rating'),
            default => $query->orderByDesc('featured')->latest(),
        };

        return view('storefront.shop', [
            'products' => $query->paginate(12)->withQueryString(),
            'categories' => Category::where('is_active', true)->orderBy('sort_order')->get(),
            'colors' => ProductVariant::query()->whereNotNull('color')->where('color', '!=', '')->distinct()->orderBy('color')->pluck('color'),
            'sizes' => ProductVariant::query()->whereNotNull('size')->where('size', '!=', '')->distinct()->orderBy('size')->pluck('size'),
            'heading' => $request->routeIs('new-arrivals') ? 'New Arrivals' : ($request->routeIs('deals') ? 'Deals' : (! empty($filters['q']) ? 'Search results' : 'Shop')),
        ]);
    }

    public function category(string $slug, Request $request)
    {
        $request->merge(['category' => $slug]);
        return $this->shop($request);
    }

    public function product(Product $product)
    {
        abort_unless($product->status === 'published', 404);
        $product->load(['category', 'images', 'variants.inventory']);
        $related = Product::with('images')->where('category_id', $product->category_id)->whereKeyNot($product->id)->where('status', 'published')->limit(4)->get();
        return view('storefront.product', compact('product', 'related'));
    }

    public function about() { return view('storefront.about'); }
}
