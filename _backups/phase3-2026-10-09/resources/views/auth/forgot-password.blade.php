@extends('layouts.app')
@section('content')
<main class="container cart-page"><div class="empty-state" style="max-width:460px;margin:auto;text-align:left"><h2>Reset your password</h2><p>Enter your email and we’ll send a reset link when mail is configured.</p><form method="post" action="{{ route('password.email') }}" style="display:grid;gap:12px">@csrf<input name="email" type="email" placeholder="Email address" required><button class="btn" type="submit">Send Reset Link</button></form></div></main>
@endsection
