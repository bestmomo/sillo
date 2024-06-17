@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- First Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>@lang('pagination.first')</span></li>
        @else
            <li><a href="{{ $paginator->url(1) }}" rel="first">@lang('pagination.first')</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Last Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}" rel="last">@lang('pagination.last')</a></li>
        @else
            <li class="disabled"><span>@lang('pagination.last')</span></li>
        @endif
    </ul>
@endif
