<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function profile(Request $request) { return view('account.profile'); }
    public function updateProfile(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'max:120'], 'phone' => ['nullable', 'max:30']]); $request->user()->update($data); return back()->with('success', 'Profile updated.');
    }
    public function addresses(Request $request) { return view('account.addresses', ['addresses' => $request->user()->addresses()->latest()->get()]); }
    public function storeAddress(Request $request)
    {
        $data = $request->validate(['label' => ['nullable', 'max:60'], 'first_name' => ['required', 'max:80'], 'last_name' => ['required', 'max:80'], 'line_1' => ['required', 'max:160'], 'line_2' => ['nullable', 'max:160'], 'city' => ['required', 'max:80'], 'state' => ['nullable', 'max:80'], 'postal_code' => ['required', 'max:20'], 'country' => ['required', 'size:2'], 'phone' => ['nullable', 'max:30']]);
        $data['label'] = $data['label'] ?: 'Shipping'; $data['is_default'] = ! $request->user()->addresses()->exists(); $request->user()->addresses()->create($data); return back()->with('success', 'Address saved.');
    }
    public function deleteAddress(Request $request, Address $address) { abort_unless($address->user_id === $request->user()->id, 403); $address->delete(); return back()->with('success', 'Address removed.'); }
    public function password(Request $request)
    {
        $data = $request->validate(['current_password' => ['required'], 'password' => ['required', 'confirmed', 'min:8']]); abort_unless(Hash::check($data['current_password'], $request->user()->password), 422, 'Current password is incorrect.'); $request->user()->update(['password' => $data['password']]); return back()->with('success', 'Password changed.');
    }
    public function orders(Request $request) { return view('account.orders', ['orders' => $request->user()->orders()->with('items')->latest()->paginate(15)]); }
    public function order(Request $request, Order $order) { abort_unless($order->user_id === $request->user()->id, 403); return view('account.order', compact('order')); }
}
