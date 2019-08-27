@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                {!! Form::open(['method' => 'GET', 'url' => '/admin/image-list', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                            <a href="{{url('admin/image-list/create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus-circle"></i>
                                    <span>
                                        @lang('admin.image_list.createButton')
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
                        <th style="width: 60%;">@lang('admin.image_list.columns.image')</th>
                        <th class="text-right">@lang('admin.image_list.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($imageLists as $image)
                        <tr>
                            <td>
                                <img src="{{ $image->imageUrl() }}" width="60" height="60" class="img-circle"
                                     style="border: 1px solid #ddd;">
                            </td>
                            <td class="text-nowrap text-right align-middle">
                                <a href="{{ url('/admin/image-list/' . $image->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="Edit">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['/admin/image-list', $image->id],
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
                    @if(count($imageLists) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.image_list.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $imageLists->render() !!}
                    </div>
                </div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
@endsection