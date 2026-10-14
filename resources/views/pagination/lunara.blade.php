@if ($paginator->hasPages())
    @if ($paginator->onFirstPage())<span class="page-button arrow">@include('components.icon', ['name'=>'chevron-right'])</span>@else<a class="page-button arrow" href="{{ $paginator->previousPageUrl() }}">@include('components.icon', ['name'=>'chevron-right'])</a>@endif
    @foreach ($elements[0] ?? [] as $page => $url)<a class="page-button {{ $page == $paginator->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>@endforeach
    @if ($paginator->hasMorePages())<a class="page-button arrow" href="{{ $paginator->nextPageUrl() }}">@include('components.icon', ['name'=>'chevron-right'])</a>@else<span class="page-button arrow">@include('components.icon', ['name'=>'chevron-right'])</span>@endif
@endif
