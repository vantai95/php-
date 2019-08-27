@extends('admin.layouts.app')
@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

<div class="m-content">
    <div class="m-portlet">
        <div class="m-portlet__body">
            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-form-label col-lg-3 col-sm-4 text-sm-right">@lang('admin.contacts.columns.name'):</label>
                <div class="col-lg-9 col-sm-8 col-form-label">
                    {{$contact->name}}
                </div>
            </div>
            <div class="form-group m-form__group row {{ $errors->has('phone') ? 'has-danger' : ''}}">
                <label for="phone" class="col-form-label col-lg-3 col-sm-12 text-sm-right">@lang('admin.contacts.columns.phone'):</label>
                <div class="col-lg-9 col-sm-12 col-form-label">
                    {{$contact->phone}}
                </div>
            </div>
            <div class="form-group m-form__group row {{ $errors->has('email') ? 'has-danger' : ''}}">
                <label for="email" class="col-form-label col-lg-3 col-sm-12 text-sm-right">@lang('admin.contacts.columns.email'):</label>
                <div class="col-lg-9 col-sm-12 col-form-label">
                    {{$contact->email}}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('content') ? 'has-danger' : ''}}">
                <label for="content" class="col-form-label col-lg-3 col-sm-12 text-sm-right">@lang('admin.contacts.columns.content'):</label>
                <div class="col-lg-9 col-sm-12 col-form-label">
                    {{$contact->content}}
                </div>
            </div>
            <div class="form-group m-form__group row {{ $errors->has('created_at') ? 'has-danger' : ''}}">
                <label for="created_at" class="col-form-label col-lg-3 col-sm-12 text-sm-right">@lang('admin.contacts.columns.created_date'):</label>
                <div class="col-lg-9 col-md-9 col-sm-12 col-form-label">
                    {{\App\Services\CommonService::formatSendDate($contact->created_at)}}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('note') ? 'has-danger' : ''}}">
                <label for="note" class="col-form-label col-lg-3 col-sm-12 text-sm-right">@lang('admin.contacts.columns.note')</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <textarea name="note" cols="20" rows="4" readonly class="col-sm-12">{{$contact->note}}</textarea>
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions">
                <div class="row">
                    <div class="col-lg-6 text-center">
                        <a href="{{url('admin/contacts')}}" class="btn btn-info">
                            @lang('admin.buttons.back')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
