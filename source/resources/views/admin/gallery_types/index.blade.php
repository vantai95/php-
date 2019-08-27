@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                {!! Form::open(['method' => 'GET', 'url' => '/admin/gallery-types', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label ">
                                            <label class="text-nowrap">
                                                @lang('admin.gallery_types.search.status')
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_type"
                                                    onchange="this.form.submit()">
                                                <option value="All" {{ ($status == "All" ? 'selected' : '') }}>
                                                    @lang('admin.gallery_types.status.all')
                                                </option>
                                                <option value="Active" {{ ($status == 'Active' ? 'selected' : '') }}>
                                                    @lang('admin.gallery_types.status.active')
                                                </option>
                                                <option value="Inactive" {{ ($status == "Inactive" ? 'selected' : '') }}>
                                                    @lang('admin.gallery_types.status.inactive')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{url('admin/gallery-types/create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus-circle"></i>
                                    <span>
                                        @lang('admin.gallery_types.createButton')
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
                        <th>@lang('admin.gallery_types.columns.name_en')</th>
                        <th>@lang('admin.gallery_types.columns.name_vi')</th>
                        <th>@lang('admin.gallery_types.columns.name_ja')</th>
                        <th>@lang('admin.gallery_types.columns.active')</th>
                        <th style="width:10%">@lang('admin.gallery_types.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($galleryTypes as $item)
                        <tr>
                            <td>{{ $item->name_en }}</td>
                            <td>{{ $item->name_vi }}</td>
                            <td>{{ $item->name_ja }}</td>
                            <td>
                                <span class="m-badge  {{$item->status_class()}} m-badge--wide">{{ $item->status() }}</span>
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ url('/admin/gallery-types/' . $item->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="Edit">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['/admin/gallery-types', $item->id],
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
                    @if(count($galleryTypes) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.gallery_types.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/gallery-types', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $galleryTypes->appends(['status' => $status])->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
                <!--end: Datatable -->
            </div>
        </div>
    </div>
@endsection