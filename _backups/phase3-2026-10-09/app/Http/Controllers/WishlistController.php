<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->user()) return redirect()->route('login')->with('info', 'Sign in to keep a persistent wishlist.');
        return view('storefront.wishlist', ['products' => $request->user()->wishlistProducts()->with('images')->latest()->get()]);
    }

    public function toggle(Request $request, Product $product)
    {
        abort_unless($request->user(), 401);
        $request->user()->wishlistProducts()->toggle([$product->id]);
        return back()->with('success', 'Wishlist updated.');
    }
}
