@extends('layouts.app')
@section('content')
<main class="container cart-page"><div class="breadcrumb"><a href="{{ route('blog') }}">Journal</a>@include('components.icon',['name'=>'chevron-right'])<span>{{ $post->title }}</span></div><article style="max-width:820px;margin:auto"><img src="{{ $post->featured_image }}" alt="{{ $post->title }}" style="width:100%;max-height:460px;object-fit:cover;border-radius:6px"><p class="eyebrow" style="margin-top:28px">Lunara Journal · {{ $post->published_at?->format('M j, Y') }}</p><h1 class="serif" style="font-size:42px;line-height:1.1">{{ $post->title }}</h1><p style="font-size:16px;color:var(--muted)">{{ $post->excerpt }}</p><div style="font-size:14px;max-width:650px">{{ $post->body }}</div></article></main>
@endsection
