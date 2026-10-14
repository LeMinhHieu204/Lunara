@extends('layouts.app')
@section('content')
<main class="container cart-page"><div class="empty-state" style="max-width:460px;margin:auto;text-align:left"><h2>Choose a new password</h2><form method="post" action="{{ route('password.update') }}" style="display:grid;gap:12px">@csrf<input type="hidden" name="token" value="{{ $token }}"><input name="email" type="email" placeholder="Email address" required><input name="password" type="password" placeholder="New password" required><input name="password_confirmation" type="password" placeholder="Confirm password" required><button class="btn" type="submit">Reset Password</button></form></div></main>
@endsection
