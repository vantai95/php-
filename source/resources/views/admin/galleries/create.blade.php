@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::open(['url' => '/admin/galleries', 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true,'enctype' => 'multipart/form-data','id' => 'submitForm']) !!}
        @include ('admin.galleries.form')
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
    // $('#submitButton').click(function (event) {
    //     if(eval($('#image_upload').val()).length > 14){
    //         event.preventDefault();
    //         $('#not_allowed').remove();
    //         $('.pt-3.save-message').after("<p id='not_allowed' class='text-danger'>{{trans('admin.galleries.flash_message.not_allowed')}}</p>");
    //     }
    // })

    </script>
@endsection
