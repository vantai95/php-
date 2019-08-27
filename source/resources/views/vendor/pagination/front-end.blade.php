@if ($paginator->hasPages())
<div class="row">
    <div class="text-center custom-paginate col-12">

    @if ($paginator->onFirstPage())
        <span class="prev">
            <a title="{{trans('pagination.previous')}}" class="custom-link inactive" data-page="1" disabled="disabled">
                {{trans('pagination.previous')}}
            </a>
        </span>
    @else
        <span class="prev">
            <a title="{{trans('pagination.previous')}}" class="custom-link active" rel="prev" data-page="1"href="{{ $paginator->previousPageUrl() }}">
                {{trans('pagination.previous')}}
            </a>
        </span>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <span>
                <a title="{{trans('pagination.more_page')}}" data-page="">
                <i class="la la-ellipsis-h"></i></a>
            </span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="custom-number active" ><a data-page="1" title="1">{{ $page }}</a></span>
                @else
                   <span class="custom-number inactive" ><a class="custom-link" data-page="{{ $page }}" title="{{ $page }}" href="{{ $url }}">{{ $page }}</a></span>
                @endif
            @endforeach
        @endif
    @endforeach
     @if ($paginator->hasMorePages())
        <span class="next">
            <a title="{{trans('pagination.next')}}" class="custom-link active" data-page="2"  href="{{ $paginator->nextPageUrl() }}" rel="next">
                {{trans('pagination.next')}}
            </a>
        </span>
    @else
        <span class="next">
            <a title="{{trans('pagination.next')}}" class="custom-link inactive" data-page="2" disabled="disabled">
                {{trans('pagination.next')}}
            </a>
        </span>
    @endif
    </div>
</div>
@endif

