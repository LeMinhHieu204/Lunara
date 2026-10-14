@extends('layouts.app')

@section('content')
<main class="container product-detail">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        @include('components.icon', ['name' => 'chevron-right'])
        <a href="{{ route('shop') }}">Shop</a>
        @include('components.icon', ['name' => 'chevron-right'])
        <span>{{ $product->name }}</span>
    </div>

    <div class="product-detail__layout">
        <div class="product-detail__gallery">
            <div class="gallery-thumbs">
                @foreach($product->images as $image)
                    <button class="gallery-thumb {{ $loop->first ? 'active' : '' }}" type="button" data-gallery="{{ $image->image_url }}">
                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?: $product->name }}">
                    </button>
                @endforeach
            </div>
            <div class="gallery-main">
                <img id="gallery-main" src="{{ $product->image_url }}" alt="{{ $product->name }}">
            </div>
        </div>

        <section class="product-detail__info">
            <p class="eyebrow">{{ $product->category->name }}</p>
            <h1>{{ $product->name }}</h1>
            <div class="rating">{{ str_repeat('★', (int) round($product->rating)) }}{{ str_repeat('☆', 5 - (int) round($product->rating)) }} <span>({{ $product->review_count }} reviews)</span></div>
            <div class="detail-price">
                <strong>${{ number_format($product->price, 2) }}</strong>
                @if($product->compare_at_price)
                    <span class="compare">${{ number_format($product->compare_at_price, 2) }}</span>
                @endif
            </div>
            <p class="detail-copy">{{ $product->description }}</p>
            <hr class="detail-rule">

            <form method="post" action="{{ route('cart.store') }}">
                @csrf
                <div class="option-label"><span>Color: <strong>{{ $product->variants->first()?->color ?: 'Warm Taupe' }}</strong></span></div>
                <div class="detail-swatches">
                    <button class="swatch active" type="button" style="background:#a58c77"></button>
                    <button class="swatch" type="button" style="background:#eee8dc"></button>
                    <button class="swatch" type="button" style="background:#1d1d1d"></button>
                </div>
                <div class="option-label"><span>Size</span><a href="{{ route('size-guide') }}">Size Guide</a></div>
                <div class="size-buttons">
                    @foreach($product->variants as $variant)
                        <label>
                            <input type="radio" name="variant_id" value="{{ $variant->id }}" {{ $loop->first ? 'checked' : '' }} hidden>
                            <span class="size-button {{ $loop->first ? 'active' : '' }}">{{ $variant->size ?: 'One size' }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="purchase-row">
                    <div class="quantity">
                        <button type="button" onclick="this.nextElementSibling.stepDown()">−</button>
                        <input name="quantity" value="1" min="1" max="20" style="width:28px;border:0;text-align:center">
                        <button type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                    </div>
                    <button class="btn" type="submit">@include('components.icon', ['name' => 'cart']) Add to Cart</button>
                    @auth
                        <button class="icon-button" type="submit" form="wishlist-form" aria-label="Save product to wishlist">
                            @include('components.icon', ['name' => 'heart'])
                        </button>
                    @else
                        <a class="icon-button" href="{{ route('login') }}" aria-label="Log in to save this product">
                            @include('components.icon', ['name' => 'heart'])
                        </a>
                    @endauth
                </div>
            </form>

            @auth
                <form id="wishlist-form" method="post" action="{{ route('wishlist.toggle', $product) }}">
                    @csrf
                </form>
            @endauth

            <div class="detail-feature-list">
                <div class="detail-feature">@include('components.icon', ['name' => 'truck']) Free shipping on orders over $50</div>
                <div class="detail-feature">@include('components.icon', ['name' => 'return']) 30-day easy returns</div>
                <div class="detail-feature">@include('components.icon', ['name' => 'shield']) Secure checkout and careful packaging</div>
            </div>
        </section>
    </div>

    <section class="section" style="padding-bottom:0">
        <div class="section-head"><h2 class="section-title">You May Also Like</h2></div>
        <div class="product-grid">
            @foreach($related as $item)
                @include('components.product-card', ['product' => $item])
            @endforeach
        </div>
    </section>
</main>

<script>
document.querySelectorAll('[data-gallery]').forEach(button => button.addEventListener('click', () => {
    document.getElementById('gallery-main').src = button.dataset.gallery;
    document.querySelectorAll('.gallery-thumb').forEach(item => item.classList.remove('active'));
    button.classList.add('active');
}));
document.querySelectorAll('.size-button').forEach(button => button.addEventListener('click', () => {
    document.querySelectorAll('.size-button').forEach(item => item.classList.remove('active'));
    button.classList.add('active');
}));
</script>
@endsection
