@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($galleryType, [ 'method' => 'PATCH', 'url' => ['/admin/gallery-types', $galleryType->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
        @include ('admin.gallery_types.form', ['submitButtonText' => trans('admin.buttons.update')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection