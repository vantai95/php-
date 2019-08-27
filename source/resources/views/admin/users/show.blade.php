@php
    $lang = Session::get('locale');
@endphp
@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="m-portlet m-portlet--full-height  ">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title m--hide">
                                Your Profile
                            </div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    <img src="{{ $user->imageUrl() }}" alt="">
                                </div>
                            </div>
                            <div class="m-card-profile__details">
                                <span class="m-card-profile__name">{{ $user->full_name }}</span>
                                <span class="m-card-profile__email m-link">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary"
                                role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active show" data-toggle="tab"
                                       href="#m_user_profile_tab_1" role="tab" aria-selected="true">
                                        <i class="flaticon-share m--hide"></i>
                                        @lang('admin.users.title.update_profile')
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2"
                                       role="tab" aria-selected="false">
                                        @lang('admin.users.title.message')
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_3"
                                       role="tab" aria-selected="false">
                                        @lang('admin.users.title.settings')
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_4"
                                           role="tab" aria-selected="false">
                                            @lang('admin.users.title.change_password')
                                        </a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="m_user_profile_tab_1">
                            {!! Form::model($user, ['method' => 'PATCH','novalidate'=>'novalidate', 'url' => $isMyProfile ? '/admin/my-profile' : ['/admin/users', $user->id], 'class' => 'user-form m-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
                            @include ('admin.users.form', ['submitButtonText' => trans('admin.buttons.update'),'imageUrl' => $user->imageUrl()])
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane" id="m_user_profile_tab_2">

                        </div>
                        <div class="tab-pane" id="m_user_profile_tab_3">

                        </div>
                        <div class="tab-pane" id="m_user_profile_tab_4">
                            {!! Form::model($user, ['method' => 'PATCH','novalidate'=>'novalidate', 'url' => $isMyProfile ? '/admin/change-password' : ['/admin/users', $user->id], 'class' => 'change-password-form m-form m-form--fit m-form--label-align-right', 'files' => true, 'id' => 'change_password_form']) !!}
                            @include ('admin.users.change-password-form', ['submitButtonText' => trans('admin.buttons.update'),'imageUrl' => $user->imageUrl()])
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var FormControls = {
            init: function () {
                $(".user-form").validate(
                    {
                        rules: {
                            email: {required: !0, email: !0, minlength: 10},
                            full_name: {required: !0, minlength: 1},
                            phone: {required: !0, digits: !0}
                        },
                        invalidHandler: function (e, r) {
                            var i = $("#m_form_1_msg");
                            i.removeClass("m--hide").show(), mApp.scrollTo(i, -200)
                        }
                    })
            }
        };
        jQuery(document).ready(function () {
            FormControls.init()
        });
    </script>
    @include('admin.users.script')
@endsection
