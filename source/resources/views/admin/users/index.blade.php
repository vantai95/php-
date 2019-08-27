@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/users', 'class' => '', 'role' => 'search']) !!}
                <div class="m-form m-form--label-align-right m--margin-bottom-20">
                    <div class="row align-items-center">
                        <div class="col-xl-10 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-3">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label style="white-space: nowrap">
                                                @lang('admin.users.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.users.statuses.all')
                                                </option>
                                                <option value="{{ \App\Models\User::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\User::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    @lang('admin.users.statuses.active')
                                                </option>
                                                <option value="{{ \App\Models\User::STATUS_FILTER['locked'] }}" {{ ($status == \App\Models\User::STATUS_FILTER['locked'] ? 'selected' : '') }}>
                                                    @lang('admin.users.statuses.locked')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="m-label m-label--single">
                                                @lang('admin.users.search.role'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="role" id="m_form_type"
                                                    onchange="this.form.submit()">
                                                <option value="" {{ ($role == "" ? 'selected' : '') }}>
                                                    @lang('admin.users.roles.all')
                                                </option>
                                                <option value="{{ \App\Models\User::ROLE_FILTER['user'] }}" {{ ($role == \App\Models\User::ROLE_FILTER['user'] ? 'selected' : '') }}>
                                                    @lang('admin.users.roles.user')
                                                </option>
                                                <option value="{{ \App\Models\User::ROLE_FILTER['admin'] }}" {{ ($role == \App\Models\User::ROLE_FILTER['admin'] ? 'selected' : '') }}>
                                                    @lang('admin.users.roles.admin')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" name="q" value="{{ Request::get('q') }}"
                                               class="form-control m-input" placeholder="@lang('admin.users.search.place_holder_text')" id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark">
                        <th style="width: 65px;"></th>
                        <th>@lang('admin.users.columns.full_name')</th>
                        <th>@lang('admin.users.columns.email')</th>
                        <th>@lang('admin.users.columns.phone')</th>
                        <th>@lang('admin.users.columns.dob')</th>
                        <th class="text-center">@lang('admin.users.columns.role')</th>
                        <th class="text-center">@lang('admin.users.columns.status')</th>
                        <th style="width:10%" class="text-center">@lang('admin.users.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $item)
                        <tr>
                            <td>
                                <img src="{{ $item->imageUrl() }}" width="40" height="40" class="img-circle">
                            </td>
                            <td>
                                {{ $item->full_name }}
                                <div class="small">{{ $item->fb_uid || $item->google_uid ? "(".$item->loginType().")" : '' }}</div>
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->birth_day }}</td>
                            <td class="text-center">{{ $item->roleName() }}</td>
                            <td class="text-center">
                                <span class="m-badge {{ $item->status_class() }} m-badge--wide">{{ $item->status() }}</span>
                            </td>
                            <td class="text-nowrap text-center">
                                <a href="{{ url('/admin/users/' . $item->id) }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="View">
                                    <i class="la la-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @if($users->count() == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.users.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $users->appends(['q' => Request::get('q'), 'role' => $role])->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection