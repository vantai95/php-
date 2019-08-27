@if ($paginator->hasPages())
    <ul class="m-datatable__pager-nav">
    @if ($paginator->currentPage()==1)
        <li>
            <a title="{{trans('pagination.first')}}" class="m-datatable__pager-link m-datatable__pager-link--first m-datatable__pager-link--disabled" data-page="1" disabled="disabled">
            <i class="la la-angle-double-left"></i></a>
        </li>
    @else
        <li>
            <a title="{{trans('pagination.first')}}" class="m-datatable__pager-link m-datatable__pager-link--first " data-page="1" href="{{ $paginator->url(1) }}&per_page={{$paginator->toArray()['per_page']}}" rel="prev" data-page="1">
            <i class="la la-angle-double-left"></i></a>
        </li>
    @endif
    @if ($paginator->onFirstPage())
        <li>
            <a title="{{trans('pagination.previous')}}" class="m-datatable__pager-link m-datatable__pager-link--prev m-datatable__pager-link--disabled" data-page="1" disabled="disabled">
                <i class="la la-angle-left"></i>
            </a>
        </li>
    @else
        <li>
            <a title="{{trans('pagination.previous')}}" class="m-datatable__pager-link m-datatable__pager-link--prev " href="{{ $paginator->previousPageUrl() }}&per_page={{$paginator->toArray()['per_page']}}" rel="prev" data-page="1" >
                <i class="la la-angle-left"></i>
            </a>
        </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li >
                <a title="{{trans('pagination.more_page')}}" class="m-datatable__pager-link m-datatable__pager-link--more-next" data-page="">
                <i class="la la-ellipsis-h"></i></a>
            </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li><a class="m-datatable__pager-link m-datatable__pager-link-number m-datatable__pager-link--active" data-page="1" title="1">{{ $page }}</a></li>
   
                @else
                   <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="{{ $page }}" title="{{ $page }}" href="{{ $url }}&per_page={{$paginator->toArray()['per_page']}}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
     @if ($paginator->hasMorePages()) 
        <li>
            <a title="{{trans('pagination.next')}}" class="m-datatable__pager-link m-datatable__pager-link--next" data-page="2"  href="{{ $paginator->nextPageUrl() }}&per_page={{$paginator->toArray()['per_page']}}" rel="next">
                <i class="la la-angle-right"></i>
            </a>
        </li>
    @else
        <li>
            <a title="{{trans('pagination.next')}}" class="m-datatable__pager-link m-datatable__pager-link--next m-datatable__pager-link--disabled" data-page="2" disabled="disabled" rel="next">
                <i class="la la-angle-right"></i>
            </a>
        </li>
    @endif
     @if ($paginator->currentPage()==$paginator->toArray()['last_page'])
        <li>
            <a title="{{trans('pagination.last')}}" class="m-datatable__pager-link m-datatable__pager-link--last  m-datatable__pager-link--first m-datatable__pager-link--disabled" data-page="{{$paginator->total()}}" disabled="disabled">
                <i class="la la-angle-double-right"></i>
            </a>
        </li>
    @else
        <li>
            <a title="{{trans('pagination.last')}}" class="m-datatable__pager-link m-datatable__pager-link--last" href="{{ $paginator->url($paginator->lastPage()) }}&per_page={{$paginator->toArray()['per_page']}}" data-page="{{$paginator->lastItem()}}" >
                <i class="la la-angle-double-right"></i>
            </a>
        </li>
    @endif
    </ul>
    
@endif
@if ($paginator->total()>0)
<div class="m-datatable__pager-info">
    <select class="selectpicker m-datatable__pager-size" title="Select page size" data-width="70px" data-selected="10" tabindex="-98" name="per_page" onchange="this.form.submit()">
        <option value="10" @if ($paginator->toArray()["per_page"] == 10) {{ "selected" }} @endif>10</option>
        <option value="20" @if ($paginator->toArray()["per_page"] == 20) {{ 'selected' }} @endif>20</option>
        <option value="30" @if ($paginator->toArray()["per_page"] == 30) {{ 'selected' }} @endif>30</option>
        <option value="50" @if ($paginator->toArray()["per_page"] == 50) {{ 'selected' }} @endif>50</option>
        <option value="100" @if ($paginator->toArray()["per_page"] == 100) {{ 'selected' }} @endif>100</option>
    </select>
    
    <span class="m-datatable__pager-detail">{{trans('pagination.displaying')}} {{$paginator->toArray()['from']}} - {{$paginator->toArray()['to']}} {{trans('pagination.of')}} {{$paginator->total()}} {{trans('pagination.records')}}</span>
</div>
@endif