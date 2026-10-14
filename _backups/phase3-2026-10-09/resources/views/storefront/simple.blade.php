@extends('layouts.app')
@section('content')
<main class="container cart-page"><div class="breadcrumb"><a href="{{ route('home') }}">Home</a>@include('components.icon',['name'=>'chevron-right'])<span>{{ $title }}</span></div><div class="empty-state"><h2>{{ $title }}</h2><p style="max-width:500px;margin:0 auto 22px">{{ $copy }}</p><a class="btn" href="{{ route('shop') }}">Shop the Collection @include('components.icon',['name'=>'arrow'])</a></div></main>
@endsection
