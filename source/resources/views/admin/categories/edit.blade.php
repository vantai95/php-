@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($category, [ 'method' => 'PATCH', 'url' => ['/admin/categories', $category->id], 'class' => 'category-form m-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
                    @include ('admin.categories.form', ['submitButtonText' => @trans('admin.categories.buttons.upgrate')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
@endsection
