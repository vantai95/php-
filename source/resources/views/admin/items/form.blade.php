@php
    $getItem = \App\Models\Item::first();
    $lang = Session::get('locale');
@endphp
<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{$errors->has('category_ids') ? 'has-danger' : ''}}">
            <label for="category_ids" class="col-form-label col-sm-12">@lang('admin.items.columns.category') <span
                        class="text-danger">*</span></label>
            <div class="col-sm-12">
                {!! Form::select('category_ids', \App\Models\Category::pluck("name_$lang", 'id'),isset($item)?$item->categories->pluck('id'):null, ['class' => 'form-control m-input', 'id' =>'category_ids']) !!}
                {!! Form::hidden('item_type', null, ['class' => 'form-control m-input', 'id'=>'item_type']) !!}
                {!! $errors->first('category_ids', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{$errors->has('sub_category_ids') ? 'has-danger' : ''}}">
            <label for="sub_category_ids"
                   class="col-form-label col-sm-12">@lang('admin.items.columns.sub_category')</label>
            <div class="col-sm-12">
                {!! Form::select('sub_category_ids', \App\Models\SubCategory::pluck("name_$lang", 'id'),isset($item)?$item->subCategories->pluck('id'):null, ['class' => 'form-control m-input', 'id' =>'sub_category_ids']) !!}
                {!! $errors->first('sub_category_ids', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{$errors->has('sub_sub_category_id') ? 'has-danger' : ''}}">
            <label for="sub_sub_category_id"
                   class="col-form-label col-sm-12">@lang('admin.items.columns.sub_sub_category')</label>
            <div class="col-sm-12">
                {!! Form::select('sub_sub_category_id', \App\Models\SubCategory::pluck("name_$lang", 'id'),isset($item)?$item->subCategories->pluck('id'):null, ['class' => 'form-control m-input', 'id' =>'sub_sub_category_id']) !!}
                {!! $errors->first('sub_sub_category_id', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.items.columns.name_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.items.columns.name_vi')</label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_ja') ? 'has-danger' : ''}}">
            <label for="name_ja" class="col-form-label col-sm-12">@lang('admin.items.columns.name_ja')</label>
            <div class="col-sm-12">
                {!! Form::text('name_ja', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_ja', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.items.columns.description_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4  {{ $errors->has('description_vi') ? 'has-danger' : ''}}">
            <label for="description_vi" class="col-form-label col-sm-12">@lang('admin.items.columns.description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4  {{ $errors->has('description_ja') ? 'has-danger' : ''}}">
            <label for="description_ja" class="col-form-label col-sm-12">@lang('admin.items.columns.description_ja')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_ja', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_ja', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('thumb_image') ? 'has-danger' : ''}}">
            <label class="col-form-label col-lg-12 col-sm-12">
                @lang('admin.items.columns.thumb_image') {{ csrf_field() }}<span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                <img class="{{isset($item) ? (empty($item->thumb_image) ? 'fade' : '') : 'fade'}}"
                     id="thumb_image_upload_thumb"
                     src="{{isset($item) ? (!empty($item->thumb_image) ? url('images/image_list/'.$item->thumb_image) :  url('common-assets/img/item_image.jpg')) : ''}}"
                     style="width: 100px;height: 100px">
                <br>
                <div class="pt-3 thumb-save-message alert alert-success alert-dismissible fade">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span class="thumb-save-message-detail"></span>
                </div>
                <div class="pt-3">
                    @include('admin.thumb_image_upload')
                </div>
            </div>
            {!! $errors->first('thumb_image', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
        </div>
        <div class="col-lg-6">
            <label class="col-form-label col-lg-12 col-sm-12 {{ $errors->has('image') ? 'has-danger' : ''}}">
                @lang('admin.items.columns.image') {{ csrf_field() }}<span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                <img class="{{isset($item) ? (empty($item->image) ? 'fade' : '') : 'fade'}}"
                     id="image_upload_thumb"
                     src="{{isset($item) ? (!empty($item->image) ? url('images/image_list/'.$item->image) :  url('common-assets/img/item_image.jpg')) : ''}}"
                     style="width: 100px;height: 100px">
                <br>
                <div class="pt-3 save-message alert alert-success alert-dismissible fade">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span class="save-message-detail"></span>
                </div>
                <div class="pt-3">
                    @include('admin.image_upload')
                </div>
            </div>
            {!! $errors->first('image', '<div id="email-error" class="form-control-feedback text-danger">:message</div>') !!}
        </div>
    </div>

    <input type="hidden" value="{{isset($item) ? $item->thumb_image : ''}}" name="thumb_image" id="thumb_image_upload">
    <input type="hidden" value="{{isset($item) ? $item->image : ''}}" name="image" id="image_upload">

    <div class="form-group m-form__group row">
        <div class="col-lg-3 {{ $errors->has('price') ? 'has-danger' : ''}}">
            <label for="price" class="col-form-label col-sm-12">@lang('admin.items.columns.price')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::number('price', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('price', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-3 {{ $errors->has('discount_price') ? 'has-danger' : ''}}" style="display:none">
            <label for="discount_price" class="col-form-label col-sm-12">@lang('admin.items.columns.discount_price')</label>
            <div class="col-sm-12">
                {!! Form::number('discount_price', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('discount_price', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-3 {{ $errors->has('active') ? 'has-danger' : ''}}">
            <label class="col-12 col-form-label">@lang('admin.items.columns.active') </label>
            <div class="col-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1,  isset($item) ? $item->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                        {!! \App\Models\Item::ITEM_STATUS['ACTIVE'] !!}
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row {{ $errors->has('sub_items') ? 'has-danger' : ''}}">
        {!! $errors->first('sub_items', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
    </div>

    <div id="app">
        <sub-items-component>

        </sub-items-component>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success','id' => 'submitButton']) !!}
                <a href="{{url('admin/items')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
