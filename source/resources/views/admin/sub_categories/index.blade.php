@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    @php
        $lang = Session::get('locale');
    @endphp

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/sub-categories', 'class' => ''])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.sub_categories.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.sub_categories.statuses.all')
                                                </option>
                                                <option value="{{ \App\Models\SubCategory::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\SubCategory::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    @lang('admin.sub_categories.statuses.active')
                                                </option>
                                                <option value="{{ \App\Models\SubCategory::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\SubCategory::STATUS_FILTER['inactive'] ? 'selected' : '') }}>
                                                    @lang('admin.sub_categories.statuses.inactive')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.sub_categories.breadcrumbs.category'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="category_id"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ $categoryId == "" ? '' : 'selected' }}>
                                                    @lang('admin.sub_categories.breadcrumbs.all')
                                                </option>
                                                @foreach(\App\Models\Category::select("name_$lang",'id')->get() as $cat)
                                                    @if($lang == 'en')
                                                        <option value="{{ $cat->id }}" {{ $categoryId != $cat->id ? '' : 'selected' }}>{{ $cat->name_en}}</option>
                                                    @elseif($lang == 'vi')
                                                        <option value="{{ $cat->id }}" {{ $categoryId != $cat->id ? '' : 'selected' }}>{{ $cat->name_vi}}</option>
                                                    @else
                                                        <option value="{{ $cat->id }}" {{ $categoryId != $cat->id ? '' : 'selected' }}>{{ $cat->name_ja}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input" name="q"
                                               value="{{ Request::get('q') }}"
                                               class="form-control m-input"
                                               placeholder="@lang('admin.sub_categories.search.place_holder_text')"
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
                            <a href="{{url('admin/sub-categories/create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus-circle"></i>
                                    <span>
                                        @lang('admin.sub_categories.breadcrumbs.new_sub_category')
                                    </span>
                                </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.sub_categories.columns.name_en')</th>
                        <th>@lang('admin.sub_categories.columns.name_vi')</th>
                        <th>@lang('admin.sub_categories.columns.name_ja')</th>
                        <th>@lang('admin.sub_categories.columns.categories')</th>
                        <th>@lang('admin.sub_categories.columns.status')</th>
                        <th>@lang('admin.sub_categories.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($subCategories as $key => $item)
                        <tr class="text-center">
                            <td>{{ $item->name_en }}</td>
                            <td>{{ $item->name_vi }}</td>
                            <td>{{ $item->name_ja }}</td>
                            <td>{{ $item->category_name }}</td>
                            <td>
                                <span class="m-badge {{ $item->status_class() }} m-badge--wide">{{ $item->status() }}</span>
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ url('/admin/sub-categories/' . $item->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.sub_categories.breadcrumbs.edit_sub_category')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'url' => ['/admin/sub-categories', $item->id],
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.sub_categories.breadcrumbs.delete_sub_category')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    @if(count($subCategories) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.sub_categories.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/sub-categories', 'class' => ''])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $subCategories->appends(['q' => Request::get('q'), 'status' => $status])->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection