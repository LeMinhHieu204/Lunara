<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(private readonly CartService $cart) {}
    public function create(Request $request) { return view('storefront.checkout', ['cart' => $this->cart->current($request)]); }
    public function store(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email'], 'first_name' => ['required', 'string', 'max:80'], 'last_name' => ['required', 'string', 'max:80'], 'line_1' => ['required', 'string', 'max:160'], 'city' => ['required', 'string', 'max:80'], 'postal_code' => ['required', 'string', 'max:20'], 'country' => ['required', 'string', 'size:2']]);
        $cart = $this->cart->current($request);
        abort_if($cart->items->isEmpty(), 422, 'Your cart is empty.');

        $order = DB::transaction(function () use ($cart, $data, $request) {
            foreach ($cart->items as $item) {
                $inventory = $item->variant->inventory()->lockForUpdate()->first();
                abort_if(! $inventory || $inventory->available() < $item->quantity, 422, "{$item->variant->product->name} is no longer available in that quantity.");
                $inventory->increment('stock_reserved', $item->quantity);
            }
            $subtotal = $cart->subtotal();
            $shipping = $subtotal >= 50 ? 0 : 5;
            $order = Order::create(['user_id' => $request->user()?->id, 'order_number' => 'LUN-'.strtoupper(str()->random(8)), 'status' => 'pending', 'payment_status' => 'pending', 'fulfillment_status' => 'unfulfilled', 'contact_email' => $data['email'], 'subtotal' => $subtotal, 'shipping_total' => $shipping, 'total' => $subtotal + $shipping, 'shipping_address' => $data, 'placed_at' => now()]);
            foreach ($cart->items as $item) $order->items()->create(['product_variant_id' => $item->product_variant_id, 'product_name' => $item->variant->product->name, 'sku' => $item->variant->sku, 'unit_price' => $item->unit_price, 'quantity' => $item->quantity, 'line_total' => $item->quantity * $item->unit_price]);
            Payment::create(['order_id' => $order->id, 'provider' => config('services.stripe.secret') ? 'stripe' : 'fake', 'status' => 'pending', 'amount' => $order->total]);
            $cart->update(['status' => 'converted']);
            return $order;
        });
        return redirect()->route('checkout.success', $order)->with('success', 'Your order was created and is awaiting payment confirmation.');
    }
    public function success(Order $order) { return view('storefront.checkout-success', compact('order')); }
}
