@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($subCategory, [ 'method' => 'PATCH', 'url' => ['/admin/sub-categories', $subCategory->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
                    @include ('admin.sub_categories.form', ['submitButtonText' => @trans('admin.sub_categories.buttons.upgrate')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection