@extends('admin.layouts.app')
@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

<div class="m-content">
    <div class="m-portlet">
        {!! Form::model($faq, [ 'method' => 'PATCH', 'url' => ['/admin/faqs', $faq->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true,'id' => 'submitForm']) !!}
        @include ('admin.faq.form', ['submitButtonText' => trans('admin.buttons.update')])
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('extra_scripts')
   
@endsection
