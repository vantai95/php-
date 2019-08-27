@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                {!! Form::open(['method' => 'GET', 'url' => '/admin/about-us', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="m-form__group m-form__group--inline">
                                <div class="m-form__label">
                                    <label class="text-nowrap">
                                        @lang('admin.abouts_us.search.status'):
                                    </label>
                                </div>
                                <div class="m-form__control">
                                    <select class="form-control m-bootstrap-select" name="status"
                                            id="m_form_status" onchange="this.form.submit()">
                                        <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                            @lang('admin.abouts_us.status.all')
                                        </option>
                                        <option value="{{ \App\Models\AboutUs::STATUS_FILTER['ACTIVE'] }}" {{ ($status == \App\Models\AboutUs::STATUS_FILTER['ACTIVE'] ? 'selected' : '') }}>
                                            @lang('admin.abouts_us.status.active')
                                        </option>
                                        <option value="{{ \App\Models\AboutUs::STATUS_FILTER['INACTIVE'] }}" {{ ($status == \App\Models\AboutUs::STATUS_FILTER['INACTIVE'] ? 'selected' : '') }}>
                                            @lang('admin.abouts_us.status.inactive')
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-md-none m--margin-bottom-10"></div>
                        </div>
                        <div class="col-xl-8 order-1 order-xl-2 m--align-right">
                            <a href="{{url('admin/about-us/create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus-circle"></i>
                                    <span>
                                        @lang('admin.abouts_us.createButton')
                                    </span>
                                </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <!--end: Search Form -->
                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark">
                        <th style="width: 65px;"></th>
                        <th>@lang('admin.abouts_us.columns.name_en')</th>
                        <th>@lang('admin.abouts_us.columns.name_vi')</th>
                        <th>@lang('admin.abouts_us.columns.name_ja')</th>
                        <th style="width:10%">@lang('admin.abouts_us.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($aboutsUs as $aboutUs)
                        <tr>
                            <td>
                                <img src="{{ $aboutUs->imageUrl() }}" width="40" height="40" class="img-circle"
                                     style="border: 1px solid #ddd;">
                            </td>
                            <td>{{ $aboutUs->name_en }}</td>
                            <td>{{ $aboutUs->name_vi }}</td>
                            <td>{{ $aboutUs->name_ja }}</td>
                            <td class="text-nowrap">
                                <a href="{{ url('/admin/about-us/' . $aboutUs->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="Edit">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['/admin/about-us', $aboutUs->id],
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
                    @if(count($aboutsUs) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.abouts_us.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $aboutsUs->appends(['status' => $status])->render() !!}
                    </div>
                </div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
@endsection