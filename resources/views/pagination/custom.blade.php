{{-- <style>
  <style type="text/css">
        /* pagination design */
        .pagination {
            justify-content: center;
            text-align: center;
        }

        .pagination a {
            color: black;
            float: left;
            padding: 6px 18px;
            text-decoration: none;
        }

        .pagination a.active {
            background-color: #09bdf7;
            color: white;
            border-radius: 5px;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
            border-radius: 5px;
        }

        /* end  pagination design */


</style>
@if ($paginator->hasPages())
    <div class="pagination">

        @if ($paginator->onFirstPage())
            <a class="disabled"><span><i class="lni lni-angle-double-left"></i></span></a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="lni lni-angle-double-left"></i></a>
        @endif



        @foreach ($elements as $element)

            @if (is_string($element))
                <a class="disabled"><span>{{ $element }}</span></a>
            @endif



            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="active"><span>{{ $page }}</span></a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach



        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="lni lni-angle-double-right"></i></a>
        @else
            <a class="disabled"><span><i class="lni lni-angle-double-right"></i></span></a>
        @endif
    </div>
@endif --}}

@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination d-flex justify-content-end mt-2">
            @if ($paginator->onFirstPage())
                <li class="d-none"><a class="page-link" href="#"></a></li>
            @else
                {{-- <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="lni lni-angle-double-left"></i></a> --}}
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
            @endif
            

            @foreach ($elements as $element)

                @if (is_string($element))
                    <li class="d-none"><a class="page-link" href="#">{{ $element }}</a></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- <a class="active"><span>{{ $page }}</span></a> --}}
                            <li class="page-item active"><a class="page-link" href="javascript:;">{{ $page }}</a></li>
                        @else
                            {{-- <a href="{{ $url }}">{{ $page }}</a> --}}
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            
            @if ($paginator->hasMorePages())
                {{-- <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="lni lni-angle-double-right"></i></a> --}}
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a></li>
            @else
                <li class="d-none"><a class="page-link" href="#"></a></li>
            @endif
        </ul>
    </nav>
@endif
