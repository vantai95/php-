@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::open(['url' => '/admin/menus', 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
                    @include ('admin.menus.form')
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection