@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($email_template, ['method' => 'PATCH','url' => ['/admin/email-templates', $email_template->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.email_templates.form', ['submitButtonText' => @trans('admin.email_templates.buttons.update')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')    
@endsection