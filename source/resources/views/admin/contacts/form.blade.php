<div class="m-portlet__body">
    <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
        <label for="name" class="col-form-label col-lg-3 col-sm-12">@lang('admin.contacts.columns.name')</label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            {{$contact->name}}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('email') ? 'has-danger' : ''}}">
        <label for="email" class="col-form-label col-lg-3 col-sm-12">@lang('admin.contacts.columns.email')</label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            {{$contact->email}}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('content') ? 'has-danger' : ''}}">
        <label for="content" class="col-form-label col-lg-3 col-sm-12">@lang('admin.contacts.columns.content')</label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            {{$contact->content}}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('created_at') ? 'has-danger' : ''}}">
        <label for="created_at"
               class="col-form-label col-lg-3 col-sm-12">@lang('admin.contacts.columns.created_date')</label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            {{\App\Services\CommonService::formatSendDate($contact->created_at)}}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('note') ? 'has-danger' : ''}}">
        <label for="note" class="col-form-label col-lg-3 col-sm-12">@lang('admin.contacts.columns.note')</label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            {!! Form::text('note', null, ['class' => 'form-control m-input']) !!}
            {!! $errors->first('note', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success']) !!}
                <a href="{{url('admin/contacts')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>