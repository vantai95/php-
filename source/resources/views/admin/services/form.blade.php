<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">
                @lang('admin.services.forms.chosen_package')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                <select name="category_id" class="form-control select2" id="category_id">
                    <option disabled>--@lang('admin.services.forms.chosen_package')--</option>
                    @foreach($categories as $index => $item)
                    @if(!empty($service))
                    <option value="{{$item->id}}" @if($item->id == $service->category_id) selected
                        @endif>{{$item->name_en}}</option>
                    @else
                    <option value="{{$item->id}}">{{$item->name_en}}</option>
                    @endif
                    @endforeach
                </select>
                {!! $errors->first('category_id', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.services.forms.name_vi')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_vi', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.services.forms.name_en')
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_en', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('short_description_vi') ? 'has-danger' : ''}}">
            <label for="short_description_vi"
                class="col-form-label col-sm-12">@lang('admin.services.forms.short_description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('short_description_vi', null, ['class' => '']) !!} {!!
                $errors->first('short_description_vi',
                '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('short_description_en') ? 'has-danger' : ''}}">
            <label for="short_description_en"
                class="col-form-label col-sm-12">@lang('admin.services.forms.short_description_en')
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('short_description_en', null, ['class' => '']) !!} {!!
                $errors->first('short_description_en',
                '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('description_vi') ? 'has-danger' : ''}}">
            <label for="description_vi"
                class="col-form-label col-sm-12">@lang('admin.services.forms.description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!} {!!
                $errors->first('description_vi', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.services.forms.description_en')
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!} {!!
                $errors->first('description_en', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-1 text-nowrap {{ $errors->has('active') ? 'has-error' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.services.forms.status')</label>
        </div>
        <div class="col-lg-2 col-md-9 col-sm-12">
            <div class="m-checkbox-inline">
                <label class="m-checkbox">
                    {!! Form::checkbox('active', 1, isset($services) ? $services->active : true, ['class' =>
                    'form-control ','name'=>'active','id'=>'active']) !!}
                    @lang('admin.services.forms.active')
                    <span></span>
                </label>
            </div>
            {!! $errors->first('active', '
            <p class="help-block">:message</p>') !!}
        </div>
        <div class="col-lg-3  text-right {{ $errors->has('type') ? 'has-warning' : ''}}">
            <label for="type" class="col-form-label">@lang('admin.services.forms.video')</label>
        </div>
        <div class="col-lg-6">
            <div class="col-sm-12">
                {!! Form::text('video', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!} {!!
                $errors->first('video',
                '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
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
        'imgInput' => (isset($service)) ? $service->image : ""
      ])

      @include('admin.components.new_media.form',[
        'title' => 'admin.media_modal.text.img_before',
        'name' => 'before',
        'width' => '4',
        'img_name_attr' => 'image_before',
        'max_files' => 1,
        'imgInput' => (isset($service)) ? $service->image_before : ""
      ])


      @include('admin.components.new_media.form',[
        'title' => 'admin.media_modal.text.img_after',
        'name' => 'after',
        'width' => '4',
        'img_name_attr' => 'image_after',
        'max_files' => 1,
        'imgInput' => (isset($service)) ? $service->image_after : ""
      ])
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">
                @lang('admin.services.forms.chosen_faq')
            </label>
            <div class="col-sm-12">
                <select multiple name="faqs[]" class="form-control select2" id="faqs">
                    <option disabled>--@lang('admin.services.forms.chosen_faq')--</option>
                    @foreach($faqs as $index => $item)
                    @if(!empty($service) )
                    <option value="{{$item->id}}" @if(in_array($item->id, $service->faqs)) selected
                        @endif>{{$item->question_en}}</option>
                    @else
                    <option value="{{$item->id}}">{{$item->question_en}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">
                @lang('admin.services.forms.chosen_service_feebacks')
            </label>
            <div class="col-sm-12">
                <select multiple name="services_feedbacks[]" class="form-control select2" id="services_feedbacks">
                    <option disabled>--@lang('admin.services.forms.chosen_service_feebacks')--</option>
                    @foreach($serviceFeedbacks as $index => $item)
                    @if(!empty($service))
                    <option value="{{$item->id}}" @if(in_array($item->id, $service->services_feedbacks))
                        selected @endif>{{$item->name_en}}</option>
                    @else
                    <option value="{{$item->id}}">{{$item->name_en}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">
                @lang('admin.items.columns.price')
            </label>
            <div class="col-sm-12">
                {!! Form::number('price', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('price', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">
                @lang('admin.services.forms.chosen_promotion')
            </label>
            <div class="col-sm-12">
                <select name="promotions" class="form-control select2" id="promotions">
                    <option disabled>--@lang('admin.services.forms.chosen_promotion')--</option>

                    @foreach($promotions as $index => $item)
                    @if(!empty($service))
                    <option value="{{$item->id}}" @if($item->id == $service->promotions) selected
                        @endif>{{$item->name_en}}</option>
                    @else
                    <option value="{{$item->id}}">{{$item->name_en}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>


</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.services.buttons.create'),
                ['class' => 'btn btn-success',
                'id' => 'submitButton']) !!}
                <a href="{{url('admin/services')}}" class="btn btn-secondary">
                    @lang('admin.services.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
