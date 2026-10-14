<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', ['stats' => ['products' => Product::count(), 'orders' => Order::count(), 'customers' => User::where('role', 'customer')->count(), 'subscribers' => NewsletterSubscriber::where('status', 'subscribed')->count()]]);
    }
    public function products(Request $request)
    {
        $products = Product::with('category')->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))->latest()->paginate(20)->withQueryString();
        return view('admin.products.index', compact('products'));
    }
    public function createProduct() { return view('admin.products.create', ['categories' => Category::orderBy('name')->get()]); }
    public function storeProduct(Request $request)
    {
        $data = $request->validate(['category_id' => ['required', 'exists:categories,id'], 'name' => ['required', 'max:160'], 'sku' => ['required', 'unique:products,sku'], 'price' => ['required', 'numeric', 'min:0'], 'description' => ['required'], 'image_url' => ['required', 'url']]);
        $image = $data['image_url']; unset($data['image_url']);
        $product = Product::create($data + ['slug' => str()->slug($data['name']).'-'.str()->lower(str()->random(4)), 'status' => 'published']);
        $product->images()->create(['image_url' => $image, 'alt_text' => $product->name, 'is_primary' => true]);
        $variant = $product->variants()->create(['sku' => $product->sku.'-OS', 'size' => 'One size', 'color' => 'Warm Taupe', 'price' => $product->price, 'is_default' => true]);
        $variant->inventory()->create(['stock_on_hand' => 20]);
        return redirect()->route('admin.products')->with('success', 'Product created.');
    }
    public function images(Product $product) { return view('admin.products.images', compact('product')); }
    public function storeImage(Request $request, Product $product)
    {
        $data = $request->validate(['image_url' => ['required', 'url'], 'alt_text' => ['nullable', 'max:180']]);
        $product->images()->create($data + ['is_primary' => ! $product->images()->exists(), 'sort_order' => $product->images()->count()]);
        return back()->with('success', 'Product image added.');
    }
    public function deleteImage(ProductImage $image) { $image->delete(); return back()->with('success', 'Product image removed.'); }
}
