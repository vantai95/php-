@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($menu, ['method' => 'PATCH','url' => ['/admin/menus', $menu->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
                    @include ('admin.menus.form', ["submitButtonText" => @trans('admin.menus.buttons.upgrate')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection