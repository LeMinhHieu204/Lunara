<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? 'Lunara Shop — considered essentials for everyday living.' }}">
    <title>{{ $title ?? 'Lunara Shop — Simplicity That Inspires' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@php
    $headerCart = app(\App\Services\CartService::class)->current(request());
    $cartCount = $headerCart->items->sum('quantity');
    $wishlistCount = auth()->check() ? auth()->user()->wishlistProducts()->count() : 0;
@endphp
<div class="announcement"><div class="announcement__message">@include('components.icon', ['name' => 'truck'])<span>Free shipping on orders over $50!</span></div><div class="announcement__links"><a href="{{ route('about') }}">About Us</a><a href="{{ route('contact') }}">Contact</a><a href="{{ route('faq') }}">FAQ</a><span>🇺🇸&nbsp; US ($) @include('components.icon', ['name' => 'chevron'])</span></div></div>
<header class="site-header" x-data="{ open: false }">
    <div class="main-nav"><button class="icon-button mobile-menu" @click="open = !open" aria-label="Open menu">@include('components.icon', ['name' => 'menu'])</button><a class="logo" href="{{ route('home') }}">LUNARA<small>SHOP</small></a>
        <nav class="nav-links" aria-label="Main navigation">
            @foreach([['home','Home'],['shop','Shop'],['categories','Categories'],['new-arrivals','New Arrivals'],['deals','Deals'],['blog','Blog']] as [$route,$label])<a class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}" href="{{ route($route) }}">{{ $label }}@if(in_array($route,['shop','categories'])) @include('components.icon', ['name'=>'chevron']) @endif</a>@endforeach
        </nav>
        <div class="header-tools"><form class="search-box" action="{{ route('search') }}" method="get"><input name="q" aria-label="Search products" placeholder="Search products..." value="{{ request('q') }}"><button class="icon-button" type="submit" aria-label="Search">@include('components.icon', ['name' => 'search'])</button></form><a class="icon-button" href="{{ auth()->check() ? route('account') : route('login') }}" aria-label="Account">@include('components.icon', ['name' => 'user'])</a><a class="icon-button" href="{{ auth()->check() ? route('wishlist') : route('login') }}" aria-label="Wishlist">@include('components.icon', ['name' => 'heart'])<span class="badge">{{ $wishlistCount }}</span></a><a class="icon-button" href="{{ route('cart') }}" aria-label="Cart">@include('components.icon', ['name' => 'cart'])<span class="badge">{{ $cartCount }}</span></a></div>
    </div>
    <div class="mobile-nav" x-show="open" x-cloak><div class="mobile-nav__head"><span>Menu</span><button class="icon-button" @click="open = false" aria-label="Close menu">@include('components.icon', ['name'=>'close'])</button></div><a href="{{ route('home') }}">Home</a><a href="{{ route('shop') }}">Shop</a><a href="{{ route('categories') }}">Categories</a><a href="{{ route('new-arrivals') }}">New Arrivals</a><a href="{{ route('deals') }}">Deals</a><a href="{{ route('blog') }}">Blog</a><a href="{{ route('about') }}">About Us</a><hr><a href="{{ route('contact') }}">Contact</a><a href="{{ route('faq') }}">FAQ</a></div>
</header>
@if(session('success') || session('info'))<div class="container" style="padding-top:12px"><div class="flash">{{ session('success') ?? session('info') }}</div></div>@endif
@if($errors->any())<div class="container" style="padding-top:12px"><div class="flash flash--error">{{ $errors->first() }}</div></div>@endif
{{ $slot ?? '' }}
@yield('content')
<footer class="site-footer"><div class="container"><div class="footer-grid"><div class="footer-brand"><a class="logo" href="{{ route('home') }}">LUNARA<small>SHOP</small></a><p>Timeless pieces, thoughtfully designed for a simpler, more beautiful life.</p></div><div class="footer-column"><h3>Shop</h3><a href="{{ route('shop') }}">All Products</a><a href="{{ route('category','clothing') }}">Clothing</a><a href="{{ route('category','bags') }}">Bags</a><a href="{{ route('category','shoes') }}">Shoes</a><a href="{{ route('category','beauty') }}">Beauty</a></div><div class="footer-column"><h3>Customer Care</h3><a href="{{ route('contact') }}">Contact Us</a><a href="{{ route('faq') }}">FAQ</a><a href="{{ route('shipping') }}">Shipping & Delivery</a><a href="{{ route('returns') }}">Returns & Refunds</a><a href="{{ route('size-guide') }}">Size Guide</a></div><div class="footer-column"><h3>Company</h3><a href="{{ route('about') }}">About Us</a><a href="{{ route('sustainability') }}">Sustainability</a><a href="{{ route('contact') }}">Careers</a></div><div class="footer-column"><h3>Legal</h3><a href="{{ route('terms') }}">Terms of Service</a><a href="{{ route('privacy') }}">Privacy Policy</a></div></div><div class="footer-bottom"><span>© {{ date('Y') }} Lunara Shop. All Rights Reserved.</span><div class="payments"><span class="payment">VISA</span><span class="payment">MC</span><span class="payment">Apple Pay</span><span class="payment">AMEX</span></div></div></div></footer>
</body>
</html>
