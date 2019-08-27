@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/sub-menus', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-bottom-20">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.sub_menus.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.sub_menus.statuses.all')
                                                </option>
                                                <option value="{{ \App\Models\SubMenu::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\Menu::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    @lang('admin.sub_menus.statuses.active')
                                                </option>
                                                <option value="{{ \App\Models\SubMenu::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\Menu::STATUS_FILTER['inactive'] ? 'selected' : '') }}>
                                                    @lang('admin.sub_menus.statuses.inactive')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{ url('/admin/sub-menus/create') }}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    @lang('admin.sub_menus.breadcrumbs.new_sub_menu')
                                </span>
                            </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.sub_menus.columns.name_en')</th>
                        <th>@lang('admin.sub_menus.columns.name_vi')</th>
                        <th>@lang('admin.sub_menus.columns.name_ja')</th>
                        <th>@lang('admin.sub_menus.columns.url')</th>
                        <th>@lang('admin.sub_menus.columns.status')</th>
                        <th>@lang('admin.sub_menus.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sub_menus as $key => $item)
                        <tr class="text-center">
                            <td>{{ $item->name_en }}</td>
                            <td>{{ $item->name_vi }}</td>
                            <td>{{ $item->name_ja }}</td>
                            <td>{{ $item->url }}</td>
                            <td>
                                <span class="m-badge {{ $item->status_class() }} m-badge--wide">{{ $item->status() }}</span>
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ url('/admin/sub-menus/' . $item->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.sub_menus.breadcrumbs.edit_sub_menu')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                'method' => 'DELETE',
                                'url' => ['/admin/sub-menus', $item->id],
                                'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.sub_menus.breadcrumbs.delete_sub_menu')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    @if(count($sub_menus) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.sub_menus.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
