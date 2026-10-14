<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Banner;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\StoreSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminResourceController extends Controller
{
    public function categories() { return $this->resource('Categories', 'categories', Category::withCount('products')->orderBy('name')->paginate(20)); }
    public function saveCategory(Request $request, ?Category $category = null)
    {
        $data = $request->validate(['name' => ['required', 'max:120'], 'slug' => ['nullable', 'max:140'], 'description' => ['nullable'], 'image_url' => ['nullable', 'url']]);
        $data['slug'] = $data['slug'] ?: str()->slug($data['name']);
        if ($category) $category->update($data); else Category::create($data + ['is_active' => true]);
        return back()->with('success', 'Category saved.');
    }
    public function deleteCategory(Category $category) { abort_if($category->products()->exists(), 422, 'Move products before deleting this category.'); $category->delete(); return back()->with('success', 'Category deleted.'); }

    public function brands() { return $this->resource('Brands', 'brands', Brand::withCount('products')->orderBy('name')->paginate(20)); }
    public function saveBrand(Request $request, ?Brand $brand = null)
    {
        $data = $request->validate(['name' => ['required', 'max:120'], 'slug' => ['nullable', 'max:140'], 'description' => ['nullable']]);
        $data['slug'] = $data['slug'] ?: str()->slug($data['name']);
        if ($brand) $brand->update($data); else Brand::create($data + ['is_active' => true]);
        return back()->with('success', 'Brand saved.');
    }
    public function deleteBrand(Brand $brand) { abort_if($brand->products()->exists(), 422, 'Move products before deleting this brand.'); $brand->delete(); return back()->with('success', 'Brand deleted.'); }

    public function inventory(Request $request)
    {
        $rows = Inventory::with('variant.product')->when($request->filled('q'), fn ($query) => $query->whereHas('variant.product', fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%')))->paginate(20)->withQueryString();
        return $this->resource('Inventory', 'inventory', $rows);
    }
    public function updateInventory(Request $request, Inventory $inventory)
    {
        $data = $request->validate(['stock_on_hand' => ['required', 'integer', 'min:0'], 'stock_reserved' => ['required', 'integer', 'min:0']]);
        abort_if($data['stock_reserved'] > $data['stock_on_hand'], 422, 'Reserved stock cannot exceed stock on hand.');
        $inventory->update($data); $this->audit('inventory.updated', $inventory, $data); return back()->with('success', 'Inventory updated.');
    }

    public function variants() { return $this->resource('Product Variants', 'variants', ProductVariant::with('product', 'inventory')->paginate(20)); }
    public function saveVariant(Request $request, ?ProductVariant $variant = null)
    {
        $data = $request->validate(['product_id' => ['required', 'exists:products,id'], 'sku' => ['required', 'max:80'], 'size' => ['nullable', 'max:30'], 'color' => ['nullable', 'max:60'], 'price' => ['nullable', 'numeric', 'min:0'], 'stock_on_hand' => ['required', 'integer', 'min:0']]);
        $stock = $data['stock_on_hand']; unset($data['stock_on_hand']);
        $variant = $variant ? tap($variant)->update($data) : ProductVariant::create($data);
        $variant->inventory()->updateOrCreate([], ['stock_on_hand' => $stock]);
        return back()->with('success', 'Variant saved.');
    }

    public function orders(Request $request) { return $this->resource('Orders', 'orders', Order::with('user')->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))->latest()->paginate(20)->withQueryString()); }
    public function updateOrder(Request $request, Order $order)
    {
        $data = $request->validate(['status' => ['required', 'in:pending,processing,shipped,completed,cancelled'], 'payment_status' => ['required', 'in:pending,paid,failed,refunded']]);
        if ($data['status'] === 'cancelled' && $order->status !== 'cancelled') $this->releaseReservedStock($order);
        $order->update($data); $order->histories()->create(['user_id' => $request->user()->id, 'status' => $data['status'], 'note' => 'Updated from Admin']); $this->audit('order.updated', $order, $data);
        return back()->with('success', 'Order updated.');
    }

    public function customers(Request $request) { return $this->resource('Customers', 'customers', User::whereIn('role', ['customer', 'staff', 'admin', 'super_admin'])->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%')->orWhere('email', 'like', '%'.$request->string('q').'%'))->latest()->paginate(20)->withQueryString()); }
    public function updateCustomer(Request $request, User $user) { $data = $request->validate(['role' => ['required', 'in:customer,staff,admin,super_admin']]); $user->update($data); $this->audit('customer.role_updated', $user, $data); return back()->with('success', 'Customer role updated.'); }

    public function coupons() { return $this->resource('Coupons', 'coupons', Coupon::latest()->paginate(20)); }
    public function saveCoupon(Request $request, ?Coupon $coupon = null)
    {
        $data = $request->validate(['code' => ['required', 'max:60'], 'type' => ['required', 'in:fixed,percent'], 'value' => ['required', 'numeric', 'min:0'], 'usage_limit' => ['nullable', 'integer', 'min:1']]);
        $data['code'] = strtoupper($data['code']); if ($coupon) $coupon->update($data); else Coupon::create($data + ['is_active' => true]); return back()->with('success', 'Coupon saved.');
    }

    public function reviews() { return $this->resource('Reviews', 'reviews', Review::with('product', 'user')->latest()->paginate(20)); }
    public function updateReview(Request $request, Review $review) { $data = $request->validate(['status' => ['required', 'in:pending,approved,rejected']]); $review->update($data); return back()->with('success', 'Review moderated.'); }

    public function banners() { return $this->resource('Homepage Banners', 'banners', Banner::orderBy('sort_order')->paginate(20)); }
    public function saveBanner(Request $request, ?Banner $banner = null)
    {
        $data = $request->validate(['name' => ['required', 'max:120'], 'eyebrow' => ['nullable', 'max:120'], 'headline' => ['required', 'max:180'], 'body' => ['nullable'], 'image_url' => ['nullable', 'url'], 'cta_label' => ['nullable', 'max:80'], 'cta_url' => ['nullable', 'max:255']]);
        if ($banner) $banner->update($data); else Banner::create($data + ['is_active' => true]); return back()->with('success', 'Banner saved.');
    }

    public function collections() { return $this->resource('Collections', 'collections', Collection::withCount('products')->latest()->paginate(20)); }
    public function saveCollection(Request $request, ?Collection $collection = null)
    {
        $data = $request->validate(['name' => ['required', 'max:120'], 'slug' => ['nullable', 'max:140'], 'description' => ['nullable'], 'image_url' => ['nullable', 'url']]); $data['slug'] = $data['slug'] ?: str()->slug($data['name']); if ($collection) $collection->update($data); else Collection::create($data + ['is_active' => true]); return back()->with('success', 'Collection saved.');
    }

    public function blogCategories() { return $this->resource('Blog Categories', 'blog-categories', BlogCategory::withCount('posts')->orderBy('name')->paginate(20)); }
    public function saveBlogCategory(Request $request, ?BlogCategory $category = null) { $data = $request->validate(['name' => ['required', 'max:120'], 'slug' => ['nullable', 'max:140']]); $data['slug'] = $data['slug'] ?: str()->slug($data['name']); if ($category) $category->update($data); else BlogCategory::create($data); return back()->with('success', 'Blog category saved.'); }

    public function blogPosts() { return $this->resource('Blog Posts', 'blog-posts', BlogPost::with('category')->latest()->paginate(20)); }
    public function saveBlogPost(Request $request, ?BlogPost $post = null)
    {
        $data = $request->validate(['title' => ['required', 'max:180'], 'slug' => ['nullable', 'max:200'], 'excerpt' => ['nullable'], 'body' => ['required'], 'featured_image' => ['nullable', 'url'], 'blog_category_id' => ['nullable', 'exists:blog_categories,id'], 'status' => ['required', 'in:draft,published']]); $data['slug'] = $data['slug'] ?: str()->slug($data['title']); $data['author_id'] = $request->user()->id; $data['published_at'] = $data['status'] === 'published' ? now() : null; if ($post) $post->update($data); else BlogPost::create($data); return back()->with('success', 'Blog post saved.');
    }

    public function newsletter() { return $this->resource('Newsletter Subscribers', 'newsletter', NewsletterSubscriber::latest()->paginate(30)); }
    public function updateNewsletter(Request $request, NewsletterSubscriber $subscriber) { $data = $request->validate(['status' => ['required', 'in:subscribed,unsubscribed']]); $subscriber->update($data + ($data['status'] === 'unsubscribed' ? ['unsubscribed_at' => now()] : ['subscribed_at' => now()])); return back()->with('success', 'Subscriber updated.'); }
    public function settings() { return $this->resource('Store Settings', 'settings', StoreSetting::orderBy('key')->paginate(30)); }
    public function saveSetting(Request $request) { $data = $request->validate(['key' => ['required', 'max:120'], 'value' => ['nullable']]); StoreSetting::updateOrCreate(['key' => $data['key']], ['value' => $data['value']]); return back()->with('success', 'Setting saved.'); }
    public function auditLogs() { return $this->resource('Audit Logs', 'audit-logs', AuditLog::latest()->paginate(30)); }

    private function resource(string $title, string $module, $rows) { return view('admin.resource', compact('title', 'module', 'rows')); }
    private function audit(string $action, $model, array $metadata = []): void { AuditLog::create(['user_id' => auth()->id(), 'action' => $action, 'auditable_type' => get_class($model), 'auditable_id' => $model->getKey(), 'metadata' => $metadata]); }
    private function releaseReservedStock(Order $order): void { foreach ($order->items as $item) $item->variant?->inventory?->decrement('stock_reserved', min($item->quantity, $item->variant->inventory->stock_reserved)); }
}
