@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="row">
            <div class="m-portlet m-portlet--full-height col-md-3 col-lg-4 select-role-portlet">
                <div class="m-portlet__body p-0">
                    <!--begin::Section-->
                    <div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">
                        <!--begin::Item-->
                        <div class="m-accordion__item">
                            <div class="m-accordion__item-head" role="tab" id="m_accordion_1_item_1_head"
                                 data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="false">
                                <span class="m-accordion__item-icon">
                                    <i class="fa fa-key"></i>
                                </span>
                                <span class="m-accordion__item-title">
                                    @lang('admin.roles.title.all')
                                </span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            <div class="m-accordion__item-body  collapse show" id="m_accordion_1_item_1_body"
                                 role="tabpanel" aria-labelledby="m_accordion_1_item_1_head"
                                 data-parent="#m_accordion_1">
                                <div class="list-group">
                                    @foreach($roleList as $item)
                                        <a href="{{url('admin/roles/'.$item->id)}}"
                                           class="list-group-item list-group-item-action list-style">
                                            <i class="la la-users"></i>
                                            {{$item->name}}
                                            <span class="ml-auto float-right m-badge m-badge--info">{{$item->total}}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Section-->
                </div>
                <div class="m-portlet__body p-0">
                    <a href="{{url('admin/roles/create')}}" class="btn btn-primary" style="width: 100%;">
                        <i class="fa fa-plus"> @lang('admin.roles.buttons.index_create')</i>
                    </a>
                </div>
            </div>
            <!--end::Portlet-->
            <div class="col-md-9 col-lg-8">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <span class="role-title float-left"> {{$role->name}}</span>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="m-portlet__body">
                            <div class="row row-eq-height">
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.users')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'u1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.users_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'u2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.users_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.galleries')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'g1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.galleries_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'g2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.galleries_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.gallery_types')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'gt1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.gallery_types_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'gt2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.gallery_types_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.items')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'i1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.items_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'i2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.items_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.events')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'e1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.events_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'e1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.events_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.event_types')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'et1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.event_types_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'et2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.event_types_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.categories')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'c1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.categories_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'c2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.categories_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.sub_categories')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'sc1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.sub_categories_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'sc2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.sub_categories_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.menus')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'m1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.menus_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'m2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.menus_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.sub_menus')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'sm1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.sub_menus_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'sm2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.sub_menus_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.currencies')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'cu1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.currencies_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'cu2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.currencies_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.promotions')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'p1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.promotions_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'p2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.promotions_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.contacts')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'ct1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.contacts_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'ct2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.contacts_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.roles')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'r1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.roles_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'r2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.roles_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.configurations')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'co1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.configurations_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'co2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.configurations_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.payment_methods')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'pmd1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.payment_methods_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'pmd2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.payment_methods_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.email_templates')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'emt1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.email_templates_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'emt2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.email_templates_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.weekly_menus')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'w1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.weekly_menus_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'w2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.weekly_menus_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.abouts_us')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'au1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.abouts_us_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'au2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.abouts_us_manage')
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">@lang('admin.roles.title.images_list')</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'il1') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.images_list_view')
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa {{App\Services\CommonService::containString($role->permissions,'il2') ? 'fa-check-circle check-icon'  : 'fa-circle-o'}}"></i> @lang('admin.roles.checkbox_title.images_list_manage')
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="m-portlet__body button-box">
                            {!! Form::open([
                                  'method' => 'DELETE',
                                  'url' => ['/admin/roles', $role->id],
                                  'style' => 'display:inline'
                               ]) !!}
                            <a href="javascript:void(0);"
                               class="btn btn-default gray-text"
                               data-animation="false"
                               onclick="confirmSubmit(event, this)"
                               title="@lang('admin.roles.title.delete')">
                                @lang('admin.roles.buttons.delete')
                            </a>
                            {!! Form::close() !!}
                            <a href="{{url("admin/roles/".$role->id."/edit")}}"
                               class="btn btn-primary">@lang('admin.roles.buttons.index_edit')</a>
                        </div>
                    </div>
                </div>
                <!--Role Member Table-->
                <div class="m-portlet">
                    <div class="m-portlet__head border-0">
                        <div class="m-portlet__head-tools">
                            <span class="role-title float-left"> @lang('admin.roles.title.members')</span>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-responsive-md">
                        <thead>
                        <tr class="role-table">
                            <td style="width: 30%">@lang('admin.roles.column.full_name')</td>
                            <td>@lang('admin.roles.column.email')</td>
                            <td>@lang('admin.roles.column.last_login')</td>
                            <td>@lang('admin.roles.column.action')</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userList as $user)
                            <tr>
                                <td>{{$user->full_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{\App\Services\CommonService::formatLastLoginDate($user->last_login)}}</td>
                                <td class="text-nowrap">
                                    {!! Form::open([
                                     'url' => ['/admin/delete-user', $user->role_id],
                                     'style' => 'display:inline'
                                     ])!!}
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <a href="javascript:void(0);"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                       data-animation="false" onclick="confirmSubmit(event, this)"><i class="la la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="tab-content">
                        <div class="m-portlet__body button-box">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                                <i class="fa fa-user-plus"></i> @lang('admin.roles.buttons.add_user')</button>
                        </div>
                    </div>

                    <!--Modal -->
                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">@lang('admin.roles.modal.title')</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {!! Form::open(['url' => '/admin/add-user/'.$role->id]) !!}
                                <div class="modal-body">
                                    <label class="col-form-label col-sm-12 modal-title-text">@lang('admin.roles.modal.select')<span
                                                class="text-danger">*</span></label>

                                    {!! Form::select('user_id', \App\Models\User::pluck('full_name', 'id'),null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('user_id', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('admin.roles.modal.close')</button>
                                    {!! Form::submit(trans('admin.roles.modal.add'), ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Table-->
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script type="text/javascript">

    </script>
@endsection
