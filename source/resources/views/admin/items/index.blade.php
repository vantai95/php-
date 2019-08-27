@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                {!! Form::open(['method' => 'GET', 'url' => '/admin/items', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label ">
                                            <label class="text-nowrap">
                                                @lang('admin.items.search.category')
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="category_id"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ $category_id == "" ? '' : 'selected' }}>
                                                    @lang('admin.items.text.all')
                                                </option>
                                                @foreach(\App\Models\Category::select("name_$lang",'id')->get() as $cat)
                                                    @if($lang == 'en')
                                                        <option value="{{ $cat->id }}" {{ $category_id != $cat->id ? '' : 'selected' }}>{{ $cat->name_en}}</option>
                                                    @elseif($lang == 'vi')
                                                        <option value="{{ $cat->id }}" {{ $category_id != $cat->id ? '' : 'selected' }}>{{ $cat->name_vi}}</option>
                                                    @else
                                                        <option value="{{ $cat->id }}" {{ $category_id != $cat->id ? '' : 'selected' }}>{{ $cat->name_ja}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input"
                                               placeholder="@lang('admin.items.search.place_holder_text')"
                                               name="q"
                                               value="{{Request::get('q')}}"
                                               id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{url('admin/items/create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus-circle"></i>
                                    <span>
                                        @lang('admin.items.createButton')
                                    </span>
                                </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>
                {{Form::close()}}

            <!--end: Search Form -->
                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark">
                        <th style="width: 65px;"></th>
                        <th>@lang('admin.items.columns.name_en')</th>
                        <th>@lang('admin.items.columns.name_vi')</th>
                        <th>@lang('admin.items.columns.name_ja')</th>
                        <th>@lang('admin.items.columns.price')</th>
                        <th style="width:10%">@lang('admin.items.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as  $item)
                        <tr>
                            <td>
                                <img src="{{ $item->imageUrl() }}" width="40" height="40" class="img-circle"
                                     style="border: 1px solid #ddd;">
                            </td>
                            <td>{{ $item->name_en }}</td>
                            <td>{{ $item->name_vi }}</td>
                            <td>{{ $item->name_ja }}</td>
                            <td>{{ $item->price }}</td>
                            <td class="text-nowrap">
                                <a href="{{ url('/admin/items/' . $item->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="Edit">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['/admin/items', $item->id],
                                'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="Delete">
                                    <i class="la la-remove"></i>
                                </a>

                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    @if(count($items) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.items.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/items', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $items->appends(['q' => Request::get('q'),'category_id' => $category_id])->render() !!}
                    </div>
                </div>
            {!! Form::close() !!}
            <!--end: Datatable -->

            </div>
        </div>
    </div>
@endsection