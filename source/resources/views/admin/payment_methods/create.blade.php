@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::open(['url' => '/admin/payment-methods', 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.payment_methods.form')
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
@endsection