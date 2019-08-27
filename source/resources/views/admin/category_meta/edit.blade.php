@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($category_meta, [ 'method' => 'PATCH', 'url' => ['/admin/category-meta', $category_meta->id], 'class' => 'category-form m-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
                    @include ('admin.category_meta.form', ['submitButtonText' => @trans('admin.category_meta.buttons.upgrate')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection