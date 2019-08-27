<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.promotions.forms.name_vi')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_vi', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.promotions.forms.name_en')
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
            <label for="description_vi" class="col-form-label col-sm-12">@lang('admin.promotions.forms.description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!} {!! $errors->first('description_vi', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.promotions.forms.description_en')
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!} {!! $errors->first('description_en', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4 text-nowrap {{ $errors->has('active') ? 'has-danger' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.promotions.forms.status')</label>
            <div class="col-sm-12">
                <div class="m-checkbox-inline ">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1, isset($promotion) ? $promotion->active : true, ['class'=>'form-control ', 'id'=>'active']) !!}
                        @lang('admin.promotions.forms.active')
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 text-nowrap {{ $errors->has('enable_detail_page') ? 'has-danger' : ''}}">
            <label for="enable_detail_page" class="col-form-label col-sm-12">@lang('admin.promotions.forms.enable_detail_page')</label>
            <div class="col-sm-12">
                <div class="m-checkbox-inline ">
                    <label class="m-checkbox">
                        {!! Form::checkbox('enable_detail_page', 1, isset($promotion) ? $promotion->enable_detail_page : true, ['class'=>'form-control ', 'id'=>'enable_detail_page']) !!}
                        @lang('admin.promotions.forms.active')
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('enable_detail_page', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 text-nowrap">
          <label for="showinhomepage" class="col-form-label col-sm-12">@lang('admin.promotions.forms.showinhomepage')</label>
          <div class="col-sm-12">
            <div class="m-checkbox-inline ">
                <label class="m-checkbox">
                    {!! Form::checkbox('show_in_home_page', 1, isset($promotion) ? $promotion->show_in_home_page : true, ['class'=>'form-control ', 'id'=>'show_in_home_page']) !!}
                    @lang('admin.promotions.forms.active')
                    <span></span>
                </label>
            </div>
          </div>
        </div>

        <!-- <div class="col-lg-4 text-nowrap {{ $errors->has('page_url') ? 'has-danger' : ''}}" id="page_url">
            <label for="video" class="col-form-label col-sm-12">@lang('admin.promotions.forms.video')</label>
            <div class="col-sm-12">
                {!! Form::text('video', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('video', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div> -->
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-6 text-nowrap {{ $errors->has('begin_date') ? 'has-danger' : ''}}" id="begin_date">
            <label for="begin_date" class="col-2 col-form-label">@lang('admin.promotions.forms.begin_date')</label>
            <div class="col-6">
                {!! Form::text('begin_date', null, [ 'class' => 'form-control','onkeydown' => 'return false;','id' => 'm_datepicker_1','readonly' => 'true']) !!}
                {!! $errors->first('begin_date', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 text-nowrap {{ $errors->has('end_date') ? 'has-danger' : ''}}" id="end_date">
            <label for="end_date" class="col-2 col-form-label">@lang('admin.promotions.forms.end_date')</label>
            <div class="col-6">
                {!! Form::text('end_date', null, [ 'class' => 'form-control','onkeydown' => 'return false;','id' => 'm_datepicker_2','readonly' => 'true']) !!}
                {!! $errors->first('end_date', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
      @include('admin.components.new_media.form',[
        'title' => 'admin.media_modal.text.upload_text',
        'name' => 'promotions',
        'width' => '4',
        'img_name_attr' => 'image',
        'max_files' => 1,
        'imgInput' => (isset($promotion)) ? $promotion->image : ""
      ])
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.promotions.buttons.create'), ['class' => 'btn
                btn-success', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/promotions')}}" class="btn btn-secondary">
                    @lang('admin.promotions.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
