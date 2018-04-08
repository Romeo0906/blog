@if ($paginator->hasPages())
    <ul class="actions">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <li><a class="button" href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a class="button" href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a></li>
        @endif
    </ul>
@endif
