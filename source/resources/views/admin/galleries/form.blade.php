<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{$errors->has('gallery_type_id') ? 'has-danger' : ''}}">
            <label for="gallery_type_id" class="col-form-label col-sm-12">@lang('admin.galleries.columns.gallery_type') <span
                        class="text-danger">*</span></label>
            <div class="col-sm-12">
                {!! Form::select('gallery_type_id', \App\Models\GalleryType::pluck("name_$lang", 'id'),isset($gallery)?$gallery->galleryTypes->id:null,
                ['class' => 'form-control m-input']) !!} {!! $errors->first('gallery_type_id', '
                <div id="email-error"
                    class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-6 {{ $errors->has('active') ? 'has-warning' : ''}}">
            <label for="active" class="col-sm-12 col-form-label">@lang('admin.galleries.columns.active') </label>
            <div class="col-sm-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1,  isset($gallery) ? $gallery->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                        {!! \App\Models\Gallery::STATUS_TEXT['ACTIVE'] !!}
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-sm-12 col-form-label">@lang('admin.galleries.columns.name_vi')
                    <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_vi', '
                <div
                    id="email-error" class="form-control-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
        <label for="name_en" class="col-form-label col-sm-12">@lang('admin.galleries.columns.name_en')</label>
        <div class="col-sm-12">
            {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_en', '
            <div
                id="email-error" class="form-control-feedback">:message</div>') !!}
    </div>
</div>
</div>

<div class="form-group m-form__group row">
    @include('admin.components.media.form',[
      'name' => 'galleries',
      'width' => '12',
      'img_name_attr' => 'images',
      'imgList' => $gallery->images
    ])
</div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success','id'=>'submitButton'])
                !!}
                <a href="{{url('admin/galleries')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
