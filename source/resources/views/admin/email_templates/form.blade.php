<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('active') ? 'has-danger' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.email_templates.forms.status')</label>
            <div class="col-sm-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1, isset($email_template) ? $email_template->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                        @lang('admin.email_templates.forms.active')
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.email_templates.forms.name_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_en', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.email_templates.forms.name_vi')</label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_vi', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_ja') ? 'has-danger' : ''}}">
            <label for="name_ja" class="col-form-label col-sm-12">@lang('admin.email_templates.forms.name_ja')</label>
            <div class="col-sm-12">
                {!! Form::text('name_ja', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_ja', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.email_templates.forms.description_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_en', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('description_vi') ? 'has-danger' : ''}}">
            <label for="description_vi" class="col-form-label col-sm-12">@lang('admin.email_templates.forms.description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_vi', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('description_ja') ? 'has-danger' : ''}}">
            <label for="description_ja" class="col-form-label col-sm-12">@lang('admin.email_templates.forms.description_ja')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_ja', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_ja', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.email_templates.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/events')}}" class="btn btn-secondary">
                    @lang('admin.email_templates.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
