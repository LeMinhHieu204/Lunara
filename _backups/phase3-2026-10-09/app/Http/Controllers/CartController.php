<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}
    public function index(Request $request) { return view('storefront.cart', ['cart' => $this->cart->current($request)]); }
    public function store(AddToCartRequest $request)
    {
        $this->cart->add($request, (int) $request->integer('variant_id'), (int) ($request->integer('quantity') ?: 1));
        return back()->with('success', 'Added to your cart.');
    }
    public function update(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:0', 'max:20']]);
        $this->cart->update($request, $item, (int) $request->integer('quantity'));
        return back()->with('success', 'Cart updated.');
    }
    public function destroy(Request $request, CartItem $item)
    {
        abort_unless($item->cart_id === $this->cart->current($request)->id, 403);
        $item->delete();
        return back()->with('success', 'Item removed.');
    }
}
