<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/shop', [StorefrontController::class, 'shop'])->name('shop');
Route::get('/categories', [StorefrontController::class, 'shop'])->name('categories');
Route::get('/category/{slug}', [StorefrontController::class, 'category'])->name('category');
Route::get('/clothing', fn () => redirect()->route('category', 'clothing'));
Route::get('/bags', fn () => redirect()->route('category', 'bags'));
Route::get('/shoes', fn () => redirect()->route('category', 'shoes'));
Route::get('/accessories', fn () => redirect()->route('category', 'accessories'));
Route::get('/beauty', fn () => redirect()->route('category', 'beauty'));
Route::get('/hats', fn () => redirect()->route('category', 'hats'));
Route::get('/new-arrivals', [StorefrontController::class, 'shop'])->name('new-arrivals');
Route::get('/deals', [StorefrontController::class, 'shop'])->name('deals');
Route::get('/search', [StorefrontController::class, 'shop'])->name('search');
Route::get('/products/{product:slug}', [StorefrontController::class, 'product'])->name('products.show');
Route::get('/about', [StorefrontController::class, 'about'])->name('about');
Route::get('/blog', [BlogPostController::class, 'index'])->name('blog');
Route::get('/blog/{post:slug}', [BlogPostController::class, 'show'])->name('blog.show');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgot'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/items', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/items/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/items/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/account', [AuthController::class, 'account'])->name('account');
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
});

Route::view('/contact', 'storefront.simple', ['title' => 'Contact Us', 'copy' => 'Our care team is here to help with orders, sizing, shipping and anything else you are considering.'])->name('contact');
Route::view('/faq', 'storefront.simple', ['title' => 'Frequently Asked Questions', 'copy' => 'Find answers about delivery, returns, sizing and caring for your Lunara pieces.'])->name('faq');
Route::view('/shipping', 'storefront.simple', ['title' => 'Shipping & Delivery', 'copy' => 'Orders over $50 ship free within the United States.'])->name('shipping');
Route::view('/returns', 'storefront.simple', ['title' => 'Returns & Refunds', 'copy' => 'Returns are accepted within 30 days of delivery on eligible items.'])->name('returns');
Route::view('/size-guide', 'storefront.simple', ['title' => 'Size Guide', 'copy' => 'Use the measurements on each product page to find your most comfortable fit.'])->name('size-guide');
Route::view('/sustainability', 'storefront.simple', ['title' => 'Sustainability', 'copy' => 'Lunara is focused on considered materials, longer wear and less waste.'])->name('sustainability');
Route::view('/privacy-policy', 'storefront.simple', ['title' => 'Privacy Policy', 'copy' => 'This demo policy page is ready to be replaced with your approved legal copy.'])->name('privacy');
Route::view('/terms', 'storefront.simple', ['title' => 'Terms of Service', 'copy' => 'This demo terms page is ready to be replaced with your approved legal copy.'])->name('terms');
