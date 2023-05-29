{{-- criar as paginas dos produtos --}}
@if ($paginator->hasPages())
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <a href="#" disabled>&laquo;</a>
        @else
            <a class="active.page" href="{{ $paginator->previousPageURL() }}" disabled>&laquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <a href="#">{{ $element }}</a>
            @endif
            @if (is_array($elements))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    @else
                        <a href="{{$url}}">{{ $page }}</a>
                  @endif
                  @endforeach
                @endif
            @endforeach

            {{-- <a class="active-page">1</a>
            <a>2</a>
            <a>3</a> --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" disabled>&laquo;</a>
            @else
            @endif

    </div>
@endif
