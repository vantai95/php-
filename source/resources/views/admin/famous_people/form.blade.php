<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.famous_people.forms.name_vi')
            <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_vi', '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.famous_people.forms.name_en')
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!} {!! $errors->first('name_en',
                '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('description_vi') ? 'has-danger' : ''}}">
            <label for="description_vi" class="col-form-label col-sm-12">@lang('admin.famous_people.forms.description_vi')
              </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!} {!! $errors->first('description_vi', '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.famous_people.forms.description_en')
                </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!} {!! $errors->first('description_en', '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-1 text-nowrap {{ $errors->has('active') ? 'has-error' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.famous_people.forms.status')</label>
        </div>
        <div class="col-lg-2 col-md-9 col-sm-12">
            <div class="m-checkbox-inline">
                <label class="m-checkbox">
                    {!! Form::checkbox('active', 1, isset($famousPeople) ? $famousPeople->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                    @lang('admin.famous_people.forms.active')
                    <span></span>
                </label>
            </div>
            {!! $errors->first('active', '
            <p class="help-block">:message</p>') !!}
        </div>
        <div class="col-lg-3  text-right {{ $errors->has('type') ? 'has-warning' : ''}}">
            <label for="type" class="col-form-label">@lang('admin.famous_people.forms.link_video')</label>
        </div>
        <div class="col-lg-6">
            <div class="col-sm-12">
                {!! Form::text('video', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!} {!! $errors->first('video',
                '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 text-nowrap {{ $errors->has('image') ? 'has-danger' : ''}}" id="image">
            <label for="image" class="col-form-label col-sm-12">@lang('admin.media_modal.text.upload_text')
            </label>
            <div class="col-sm-12">
                <img class="{{isset($famousPeople) ? (empty($famousPeople->image) ? 'fade' : '') : 'fade'}}"
                        id="image_upload_thumb"
                        src="{{isset($famousPeople) ? ( !empty($famousPeople->image) ? url('images/image_list/'.$famousPeople->image) :  url('common-assets/img/promotion_image.png')) : ''}}"
                        style="width: 100px;height: 100px">
                <br>
                <div class="pt-3 save-message alert alert-success alert-dismissible fade">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span class="save-message-detail"></span>
                </div>
                <div class="pt-3">
                    @include('admin.image_upload')
                </div>
                {!! $errors->first('image', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>
    <input type="hidden" value="{{isset($famousPeople) ? $famousPeople->image : ''}}" name="image" id="image_upload">
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.famous_people.buttons.update'), ['class' =>
                'btn btn-accent m-btn m-btn--air m-btn--custom', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/famous-people')}}" type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom btn-cancel">
                        @lang('admin.famous_people.buttons.cancel')
                    </a>
            </div>
        </div>
    </div>
</div>
