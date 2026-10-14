<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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
        $query = Product::with(['category', 'images', 'variants.inventory'])->where('status', 'published');
        $category = $request->string('category')->toString();
        if ($category) $query->whereHas('category', fn ($builder) => $builder->where('slug', $category));
        if ($request->filled('q')) $query->where(fn ($builder) => $builder->where('name', 'like', '%'.$request->string('q').'%')->orWhere('description', 'like', '%'.$request->string('q').'%'));
        if ($request->boolean('sale') || $request->routeIs('deals')) $query->where('on_sale', true);
        if ($request->routeIs('new-arrivals')) $query->where('new_arrival', true);
        match ($request->string('sort')->toString()) {
            'price-asc' => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'rating' => $query->orderByDesc('rating'),
            default => $query->orderByDesc('featured')->latest(),
        };

        return view('storefront.shop', [
            'products' => $query->paginate(12)->withQueryString(),
            'categories' => Category::where('is_active', true)->orderBy('sort_order')->get(),
            'heading' => $request->routeIs('new-arrivals') ? 'New Arrivals' : ($request->routeIs('deals') ? 'Deals' : ($request->filled('q') ? 'Search results' : 'Shop')),
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
