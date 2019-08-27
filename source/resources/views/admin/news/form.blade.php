<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('news_type_id') ? 'has-danger' : ''}}">
            <label for="news_type_id" class="col-form-label col-sm-12">@lang('admin.news.forms.news_type')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::select('news_type_id', $news_types, null, ['class' => 'form-control m-input']) !!} {!! $errors->first('news_type_id',
                '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('active') ? 'has-danger' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.news.forms.status')</label>
            <div class="col-sm-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1, isset($news) ? $news->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                        @lang('admin.news.forms.active')
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.news.forms.name_vi')
            <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_vi', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.news.forms.name_en')
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_en', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('short_description_vi') ? 'has-danger' : ''}}">
            <label for="short_description_vi" class="col-form-label col-sm-12">@lang('admin.promotions.forms.short_description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('short_description_vi', null, ['class' => 'summernote']) !!} {!! $errors->first('short_description_vi',
                '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('short_description_en') ? 'has-danger' : ''}}">
            <label for="short_description_en" class="col-form-label col-sm-12">@lang('admin.promotions.forms.short_description_en')
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('short_description_en', null, ['class' => 'summernote']) !!} {!! $errors->first('short_description_en',
                '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('description_vi') ? 'has-danger' : ''}}">
            <label for="description_vi" class="col-form-label col-sm-12">@lang('admin.news.forms.description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!} {!! $errors->first('description_vi', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.news.forms.description_en')
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!} {!! $errors->first('description_en', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
      @include('admin.components.new_media.form',[
        'title' => 'admin.media_modal.text.upload_text',
        'name' => 'services',
        'width' => '4',
        'img_name_attr' => 'image',
        'max_files' => 1,
        'imgInput' => (isset($news)) ? $news->image : ""
      ])
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.news.buttons.create'), ['class' => 'btn btn-success',
                'id' => 'submitButton']) !!}
                <a href="{{url('admin/news')}}" class="btn btn-secondary">
                    @lang('admin.news.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
