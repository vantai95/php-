@php
    $lang = Session::get('locale');
@endphp
<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('active') ? 'has-warning' : ''}}">
            <label class="col-12 col-form-label">@lang('admin.abouts_us.columns.active') </label>
            <div class="col-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1,  isset($aboutUs) ? $aboutUs->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                        {!! \App\Models\AboutUs::STATUS_FILTER['ACTIVE'] !!}
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.abouts_us.columns.name_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.abouts_us.columns.name_vi')</label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_ja') ? 'has-danger' : ''}}">
            <label for="name_ja" class="col-form-label col-sm-12">@lang('admin.abouts_us.columns.name_ja')</label>
            <div class="col-sm-12">
                {!! Form::text('name_ja', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_ja', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.abouts_us.columns.description_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4  {{ $errors->has('description_vi') ? 'has-danger' : ''}}">
            <label for="description_vi" class="col-form-label col-sm-12">@lang('admin.abouts_us.columns.description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4  {{ $errors->has('description_ja') ? 'has-danger' : ''}}">
            <label for="description_ja" class="col-form-label col-sm-12">@lang('admin.abouts_us.columns.description_ja')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_ja', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_ja', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('short_description_en') ? 'has-danger' : ''}}">
            <label for="short_description_en" class="col-form-label col-sm-12">@lang('admin.abouts_us.columns.short_description_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('short_description_en', null, ['class' => 'summernote']) !!}
                {!! $errors->first('short_description_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4  {{ $errors->has('short_description_vi') ? 'has-danger' : ''}}">
            <label for="short_description_vi" class="col-form-label col-sm-12">@lang('admin.abouts_us.columns.short_description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('short_description_vi', null, ['class' => 'summernote']) !!}
                {!! $errors->first('short_description_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4  {{ $errors->has('short_description_ja') ? 'has-danger' : ''}}">
            <label for="short_description_ja" class="col-form-label col-sm-12">@lang('admin.abouts_us.columns.short_description_ja')</label>
            <div class="col-sm-12">
                {!! Form::textarea('short_description_ja', null, ['class' => 'summernote']) !!}
                {!! $errors->first('short_description_ja', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4 text-nowrap {{ $errors->has('image') ? 'has-danger' : ''}}" id="image">
            <label for="image" class="col-form-label col-sm-12">@lang('admin.media_modal.text.upload_text')</label>
            <div class="col-sm-12">
                <img class="{{isset($aboutUs) ? (empty($aboutUs->image) ? 'fade' : '') : 'fade'}}"
                     id="image_upload_thumb"
                     src="{{isset($aboutUs) ? ( !empty($aboutUs->image) ? url('images/image_list/'.$aboutUs->image) :  url('common-assets/img/gallery_image.jpg')) : ''}}"
                     style="width: 100px;height: 100px">
                <br>
                <div class="pt-3 save-message alert alert-success alert-dismissible fade">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span class="save-message-detail"></span>
                </div>
                <div class="pt-3">
                    @include('admin.image_upload')
                </div>
                {!! $errors->first('image', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <input type="hidden" value="{{isset($aboutUs) ? $aboutUs->image : ''}}" name="image" id="image_upload">
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success','id' => 'submitButton']) !!}
                <a href="{{url('admin/about-us')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
