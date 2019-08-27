@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($event_type, ['method' => 'PATCH','url' => ['/admin/event-types', $event_type->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
                    @include ('admin.event_types.form', ['submitButtonText' => @trans('admin.event_types.buttons.upgrate')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection