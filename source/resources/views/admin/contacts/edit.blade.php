@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($contact,['method' => 'PATCH', 'url' => ['/admin/contacts', $contact->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
        @include ('admin.contacts.form',['submitButtonText' => trans('admin.buttons.update')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection