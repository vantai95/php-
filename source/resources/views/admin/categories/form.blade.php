

  <div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.categories.forms.name_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
                {!! $errors->first('name_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-6 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.categories.forms.name_vi')</label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.categories.forms.description_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-6 {{ $errors->has('description_vi') ? 'has-danger' : ''}}">
            <label for="description_vi" class="col-form-label col-sm-12">@lang('admin.categories.forms.description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-1 text-nowrap {{ $errors->has('active') ? 'has-error' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.categories.forms.status')</label>
        </div>
        <div class="col-lg-2 col-md-9 col-sm-12">
            <div class="m-checkbox-inline">
                <label class="m-checkbox">
                    {!! Form::checkbox('active', 1, isset($category) ? $category->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                    @lang('admin.categories.forms.active')
                    <span></span>
                </label>
            </div>
            {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
      @include('admin.components.new_media.form',[
        'title' => 'admin.media_modal.text.upload_text',
        'name' => 'categories',
        'width' => '4',
        'img_name_attr' => 'image',
        'max_files' => 1,
        'imgInput' => (isset($category)) ? $category->image : ""
      ])
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-6 text-nowrap {{ $errors->has('active') ? 'has-error' : ''}}">
            <label for="active" class="col-form-label col-sm-12">Danh mục</label>
        </div>
        <div class="col-lg-6 text-nowrap {{ $errors->has('active') ? 'has-error' : ''}}">
          <button class="btn btn-success pull-right" onclick="addCategoryMeta()" type="button" name="button">
            <i class="fa fa-plus"></i>
          </button>
        </div>
        <div class="col-lg-12" id="category_metas">
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.categories.buttons.create'), ['class' => 'btn btn-accent m-btn m-btn--air m-btn--custom']) !!}
                <a href="{{url('admin/categories')}}" type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom btn-cancel">
                    @lang('admin.categories.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    @parent
    <script type="text/javascript">
        var FormControls = {
            init: function () {
                $(".category-form").validate(
                    {
                        invalidHandler: function (e, r) {
                            var i = $("#m_form_1_msg");
                            i.removeClass("m--hide").show(), mApp.scrollTo(i, -200)
                        }
                    })
            }
        };
        jQuery(document).ready(function () {
            FormControls.init()
        });

    </script>
    @include('admin.categories.meta_script')
@endsection
