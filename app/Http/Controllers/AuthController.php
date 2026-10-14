<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function loginForm() { return view('auth.login'); }
    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);
        if (! Auth::attempt($credentials, $request->boolean('remember'))) return back()->withErrors(['email' => 'Those credentials did not match our records.'])->onlyInput('email');
        $request->session()->regenerate();
        return redirect()->intended('/account');
    }
    public function registerForm() { return view('auth.register'); }
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->safe()->only(['name', 'email', 'password']) + ['role' => 'customer']);
        Auth::login($user);
        return redirect('/account')->with('success', 'Welcome to Lunara.');
    }
    public function forgotForm() { return view('auth.forgot-password'); }
    public function forgot(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);
        Password::sendResetLink($request->only('email'));
        return back()->with('success', 'If that address is registered, a reset link has been requested.');
    }
    public function resetForm(string $token) { return view('auth.reset-password', compact('token')); }
    public function reset(Request $request)
    {
        $data = $request->validate(['token' => ['required'], 'email' => ['required', 'email'], 'password' => ['required', 'confirmed', 'min:8']]);
        $status = Password::reset($data, function (User $user, string $password) { $user->forceFill(['password' => $password])->save(); });
        return $status === Password::PASSWORD_RESET ? redirect()->route('login')->with('success', 'Your password has been reset.') : back()->withErrors(['email' => __($status)]);
    }
    public function logout(Request $request)
    {
        Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
        return redirect('/');
    }
    public function account(Request $request) { return view('account.index', ['orders' => $request->user()->orders()->latest()->get()]); }
}
