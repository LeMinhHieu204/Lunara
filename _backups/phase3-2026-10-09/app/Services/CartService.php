<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function current(Request $request): Cart
    {
        $sessionId = $request->session()->getId();
        $cart = auth()->check()
            ? Cart::firstOrCreate(['user_id' => auth()->id(), 'status' => 'active'], ['currency' => 'USD'])
            : Cart::firstOrCreate(['session_id' => $sessionId, 'status' => 'active'], ['currency' => 'USD']);

        if (auth()->check()) {
            $guest = Cart::where('session_id', $sessionId)->where('status', 'active')->first();
            if ($guest && $guest->id !== $cart->id) {
                foreach ($guest->items as $guestItem) {
                    $item = $cart->items()->firstOrNew(['product_variant_id' => $guestItem->product_variant_id]);
                    $item->quantity = ($item->quantity ?? 0) + $guestItem->quantity;
                    $item->unit_price = $guestItem->unit_price;
                    $item->save();
                }
                $guest->delete();
            }
        }

        return $cart->load('items.variant.product.images', 'items.variant.inventory');
    }

    public function add(Request $request, int $variantId, int $quantity = 1): Cart
    {
        return DB::transaction(function () use ($request, $variantId, $quantity) {
            $variant = ProductVariant::with('product', 'inventory')->lockForUpdate()->findOrFail($variantId);
            $available = $variant->inventory?->available() ?? 0;
            $cart = $this->current($request);
            $existing = $cart->items()->where('product_variant_id', $variant->id)->first();
            $requested = ($existing?->quantity ?? 0) + $quantity;

            abort_if($requested > $available, 422, 'That variant does not have enough stock.');
            $cart->items()->updateOrCreate(
                ['product_variant_id' => $variant->id],
                ['quantity' => $requested, 'unit_price' => $variant->price ?: $variant->product->price],
            );
            return $cart->fresh('items.variant.product.images');
        });
    }

    public function update(Request $request, CartItem $item, int $quantity): Cart
    {
        abort_unless($item->cart_id === $this->current($request)->id, 403);
        if ($quantity < 1) $item->delete();
        else {
            $available = $item->variant->inventory?->available() ?? 0;
            abort_if($quantity > $available, 422, 'That variant does not have enough stock.');
            $item->update(['quantity' => $quantity]);
        }
        return $this->current($request);
    }
}
