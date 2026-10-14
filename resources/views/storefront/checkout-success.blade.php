@extends('layouts.app')
@section('content')
<main class="container cart-page"><div class="empty-state"><div>@include('components.icon',['name'=>'shield'])</div><h2>Thank you for your order</h2><p>Order <strong>{{ $order->order_number }}</strong> has been created and is awaiting payment confirmation.</p><a class="btn" href="{{ route('account') }}">View Order History @include('components.icon',['name'=>'arrow'])</a></div></main>
@endsection
