<ul class="stui-page text-center cleafix">
    <ul class="myui-page text-center clearfix">
        @if ($paginator->hasPages())
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><a aria-="page" class="btn ">{{ $page }}</a></li>
                        @else
                            <li class=""><a class="btn" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

        @endif
    </ul>
</ul>
