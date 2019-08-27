@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($gallery, [ 'method' => 'PATCH', 'url' => ['/admin/galleries', $gallery->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true, 'id' => 'submitForm']) !!}
        @include ('admin.galleries.form', ['submitButtonText' => trans('admin.buttons.update')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
        
@endsection
