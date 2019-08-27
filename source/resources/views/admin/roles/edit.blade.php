@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($role, ['method' => 'PATCH','url' => ['/admin/roles', $role->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
        @include ('admin.roles.form', ["submitButtonText" => @trans('admin.roles.buttons.form_edit')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection