<div class="module-footer">
    <div id="page">
        @if ($paginator->hasPages())

            @if ($paginator->onFirstPage())
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-number page-previous"
                   title="@lang('pagination.previous')"> Trang trước </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <a href=""
                       class="page-number page-previous"
                       style="display:none;"
                       title="上一页">{{ $element }}</a>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-number page-current display">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-number display"
                               title="{{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="page-number page-next"
                   title="@lang('pagination.next')"> Trang sau </a>
            @else
            @endif
        @endif
    </div>
</div>
