@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                {!! Form::open(['method' => 'GET', 'url' => '/admin/galleries', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label ">
                                            <label class="text-nowrap">
                                                @lang('admin.galleries.search.gallery_type')
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="gallery_type_id"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ $gallery_type_id == "" ? '' : 'selected' }}>
                                                    @lang('admin.galleries.text.all')
                                                </option>
                                                @foreach(\App\Models\GalleryType::select("name_$lang as name",'id')->get() as $gallery_type)
                                                    <option value="{{ $gallery_type->id }}" {{ $gallery_type_id != $gallery_type->id ? '' : 'selected' }}>{{ $gallery_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{url('admin/galleries/create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus-circle"></i>
                                    <span>
                                        @lang('admin.galleries.createButton')
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
                    <tr class="table-dark text-center">
                        <th>@lang('admin.galleries.columns.image')</th>
                        <th>@lang('admin.galleries.columns.name_vi')</th>
                        <th>@lang('admin.galleries.columns.gallery_type')</th>
                        <th>@lang('admin.galleries.columns.active')</th>
                        <th>@lang('admin.galleries.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($galleries as  $item)
                        <tr class="text-center">
                            <td class="align-middle">
                                <img src="{{ $item->imageUrl() }}" width="40" height="40" class="img-circle"
                                     style="border: 1px solid #ddd;">
                            </td>
                            <td class="align-middle">{{ $item->name_vi }}</td>
                            <td class="align-middle">{{ $item->gallery_type_name }}</td>
                            <td class="align-middle">
                                <span class="m-badge  {{$item->status_class()}} m-badge--wide">{{ $item->status() }}</span>
                            </td>
                            <td class="text-nowrap align-middle">
                                <a href="{{ url('/admin/galleries/' . $item->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="Edit">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['/admin/galleries', $item->id],
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
                    @if(count($galleries) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.galleries.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/galleries', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $galleries->appends(['gallery_type_id' => $gallery_type_id])->render() !!}
                    </div>
                </div>
            {{Form::close()}}
            <!--end: Datatable -->

            </div>
        </div>
    </div>
@endsection
