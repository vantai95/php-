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
                            <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_1_head"
                                 data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="true">
                                <span class="m-accordion__item-icon">
                                    <i class="fa fa-key"></i>
                                </span>
                                <span class="m-accordion__item-title">
                                    @lang('admin.roles.title.all')
                                </span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            <div class="m-accordion__item-body collapse" id="m_accordion_1_item_1_body"
                                 role="tabpanel" aria-labelledby="m_accordion_1_item_1_head"
                                 data-parent="#m_accordion_1">
                                <div class="list-group">
                                    @foreach($roles as $role)
                                        <a href="#" class="list-group-item list-group-item-action list-style">
                                            <i class="la la-users"></i>
                                            {{$role->name}}
                                            <span class="ml-auto float-right m-badge m-badge--info">{{rand(1,10)}}</span>
                                        </a>
                                        {{--<a href="#" class="list-group-item list-group-item-action list-style">--}}
                                            {{--<i class="la la-users"></i>--}}
                                            {{--Employee 1--}}
                                            {{--<span class="ml-auto float-right m-badge m-badge--info">{{rand(1,10)}}</span>--}}
                                        {{--</a>--}}
                                        {{--<a href="#" class="list-group-item list-group-item-action list-style">--}}
                                            {{--<i class="la la-users"></i>--}}
                                            {{--Employee 2--}}
                                            {{--<span class="ml-auto float-right m-badge m-badge--info">{{rand(1,10)}}</span>--}}
                                        {{--</a>--}}
                                        {{--<a href="#" class="list-group-item list-group-item-action list-style">--}}
                                            {{--<i class="la la-users"></i>--}}
                                            {{--Employee 3--}}
                                            {{--<span class="ml-auto float-right m-badge m-badge--info">{{rand(1,10)}}</span>--}}
                                        {{--</a>--}}
                                        {{--<a href="#" class="list-group-item list-group-item-action list-style">--}}
                                            {{--<i class="la la-users"></i>--}}
                                            {{--Employee 4--}}
                                            {{--<span class="ml-auto float-right m-badge m-badge--info">{{rand(1,10)}}</span>--}}
                                        {{--</a>--}}
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
                        <i class="fa fa-plus"> Create New Role</i>
                    </a>
                </div>
            </div>
            <!--end::Portlet-->
            <div class="col-md-9 col-lg-8">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <span class="role-title float-left"> IT</span>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="m-portlet__body">
                            <div class="row row-eq-height">
                                <div class="col-md-3">
                                    <span class="role-content-title">GALLERIES</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> View All Galleries
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> Create New Gallery
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> Edit Gallery
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> Delete Gallery
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">ITEMS</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> View All Items
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> Create New Items
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> Edit Items
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> Delete Items
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">CATEGORIES</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa fa-circle-o"></i> View All Categories
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa fa-circle-o"></i> Create New Categories
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa fa-circle-o"></i> Edit Categories
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa fa-circle-o"></i> Delete Categories
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">USERS</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa fa-circle-o"></i> View All Users
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa fa-circle-o"></i> Edit User Profile
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">CONTACTS</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> View All Contacts
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-check-circle check-icon"></i> Edit Contacts
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <span class="role-content-title">PROMOTIONS</span>
                                    <ul class="list-group pt-list-5">
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-circle-o "></i> View All Promotions
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-circle-o"></i> Edit Contacts
                                        </li>
                                        <li class="list-group-item role-content-list">
                                            <i class="fa fa-circle-o"></i> Edit Contacts
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="m-portlet__body button-box">
                            <a href="{{url("#")}}" class="btn btn-default gray-text">Delete Role</a>
                            <a href="{{url("admin/roles/edit")}}" class="btn btn-primary">Edit Role</a>
                        </div>
                    </div>
                </div>
                <!--Role Member Table-->
                <div class="m-portlet">
                    <div class="m-portlet__head border-0">
                        <div class="m-portlet__head-tools">
                            <span class="role-title float-left"> Members</span>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-responsive-md">
                        <thead>
                        <tr class="role-table">
                            <td style="width: 30%">Full Name</td>
                            <td>Email</td>
                            <td>Last Login</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userList as $userList)
                        <tr>
                            <td>{{$userList->full_name}}</td>
                            <td>{{$userList->email}}</td>
                            <td>2018-10-07 12:01</td>
                            <td class="text-nowrap">
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"><i class="la la-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>Toan Le</td>
                            <td>tl@gmail.com</td>
                            <td>2018-10-07 14:01</td>
                            <td class="text-nowrap">
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"><i class="la la-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Phan Thi Thuy Nguyen</td>
                            <td>nguyenptt@gmail.com</td>
                            <td>2018-10-07 16:01</td>
                            <td class="text-nowrap">
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"><i class="la la-trash"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="tab-content">
                        <div class="m-portlet__body button-box">
                            <a href="{{url("#")}}" class="btn btn-primary"><i class="fa fa-user-plus"></i> Add User</a>
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
