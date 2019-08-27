<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">
                @lang('admin.category_meta.forms.chosen_package')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                <select name="category_id" class="form-control select2" id="category_id">
                    <option disabled>--@lang('admin.category_meta.forms.chosen_package')--</option>
                    @foreach($categories as $index => $item)
                    @if(!empty($category_meta))
                    <option value="{{$item->id}}" @if($item->id == $category_meta->category_id) selected
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
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.category_meta.forms.name_vi')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_vi', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.category_meta.forms.name_en')
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_en', '
                <p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>


</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.category_meta.buttons.create'),
                ['class' => 'btn btn-success',
                'id' => 'submitButton']) !!}
                <a href="{{url('admin/category-meta')}}" class="btn btn-secondary">
                    @lang('admin.category_meta.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
