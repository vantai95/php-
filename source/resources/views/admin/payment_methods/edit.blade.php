@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($payment_method, ['method' => 'PATCH','url' => ['/admin/payment-methods', $payment_method->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.payment_methods.form', ['submitButtonText' => @trans('admin.payment_methods.buttons.update')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')    
@endsection