<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('event_type_id') ? 'has-danger' : ''}}">
            <label for="event_type_id" class="col-form-label col-sm-12">@lang('admin.events.forms.event_type')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::select('event_type_id', $event_types, null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('event_type_id', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('active') ? 'has-danger' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.events.forms.status')</label>
            <div class="col-sm-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1, isset($event) ? $event->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                        @lang('admin.events.forms.active')
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('video') ? 'has-danger' : ''}}">
        <label for="video" class="col-form-label col-sm-12">@lang('admin.events.forms.video')</label>
            <div class="col-sm-12">
                {!! Form::text('video', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
                {!! $errors->first('video','<div id="video-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.events.forms.name_vi')
            <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_vi', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.events.forms.name_en')
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_en', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('description_vi') ? 'has-danger' : ''}}">
            <label for="description_vi" class="col-form-label col-sm-12">@lang('admin.events.forms.description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!} {!! $errors->first('description_vi', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.events.forms.description_en')
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!} {!! $errors->first('description_en', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('location') ? 'has-danger' : ''}}">
            <label for="location" class="col-form-label col-sm-12">@lang('admin.events.forms.location')</label>
            <div class="col-sm-12">
                {!! Form::text('location', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
                {!! $errors->first('location','<div id="location-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('timeline') ? 'has-danger' : ''}}">
            <label for="timeline" class="col-form-label col-sm-12">@lang('admin.events.forms.timeline')</label>
            <div class="col-sm-12">
                {!! Form::text('timeline', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
                {!! $errors->first('timeline','<div id="timeline-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('date_begin') ? 'has-danger' : ''}}">
            <label for="date_begin" class="col-form-label col-sm-12">@lang('admin.events.forms.date_begin')</label>
            <div class="col-sm-12">
                {!! Form::text('date_begin', (isset($event) && isset($event->date_begin) ) ? date('Y-m-d',strtotime($event->date_begin)) : date('Y-m-d'), ['id' => 'date_begin', 'class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
                {!! $errors->first('date_begin','<div id="date_begin-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        @include('admin.components.new_media.form',[
          'title' => 'admin.media_modal.text.upload_text',
          'name' => 'events',
          'width' => '4',
          'img_name_attr' => 'image',
          'max_files' => 1,
          'imgInput' => (isset($event)) ? $event->image : ""
        ])
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.events.buttons.create'), ['class' => 'btn btn-success',
                'id' => 'submitButton']) !!}
                <a href="{{url('admin/events')}}" class="btn btn-secondary">
                    @lang('admin.events.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
