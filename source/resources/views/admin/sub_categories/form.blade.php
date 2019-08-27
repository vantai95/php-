<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('category_id') ? 'has-danger' : ''}}">
            <label for="category_id" class="col-form-label col-sm-12">@lang('admin.sub_categories.forms.categories')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::select('category_id', $categories, null, ['class' => 'form-control m-input','id' => 'category_id']) !!}
                {!! $errors->first('category_id', '<div class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('parent_id') ? 'has-danger' : ''}}">
            <label for="parent_id"
                   class="col-form-label col-sm-12">@lang('admin.sub_categories.forms.sub_sub_categories')
            </label>
            <div class="col-sm-12">
                {!! Form::select('parent_id', \App\Models\SubCategory::pluck("name_$lang", 'id'), isset($subCategory)?$subCategory->pluck('id'):null, ['class' => 'form-control m-input','id' => 'parent_id']) !!}
                {!! $errors->first('parent_id', '<div class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.sub_categories.forms.name_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
                {!! $errors->first('name_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-label col-sm-12">@lang('admin.sub_categories.forms.name_vi')</label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_ja') ? 'has-danger' : ''}}">
            <label for="name_ja" class="col-form-label col-sm-12">@lang('admin.sub_categories.forms.name_ja')</label>
            <div class="col-sm-12">
                {!! Form::text('name_ja', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_ja', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('description_en') ? 'has-danger' : ''}}">
            <label for="description_en"
                   class="col-form-label col-sm-12">@lang('admin.sub_categories.forms.description_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('description_vi') ? 'has-danger' : ''}}">
            <label for="description_vi"
                   class="col-form-label col-sm-12">@lang('admin.sub_categories.forms.description_vi')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_vi', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('description_ja') ? 'has-danger' : ''}}">
            <label for="description_ja"
                   class="col-form-label col-sm-12">@lang('admin.sub_categories.forms.description_ja')</label>
            <div class="col-sm-12">
                {!! Form::textarea('description_ja', null, ['class' => 'summernote']) !!}
                {!! $errors->first('description_ja', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('active') ? 'has-danger' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.sub_categories.forms.status')</label>
            <div class="col-sm-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1, isset($subCategory) ? $subCategory->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                        @lang('admin.sub_categories.forms.active')
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '<p class="form-control-feedback">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.sub_categories.buttons.create'), ['class' => 'btn btn-accent m-btn m-btn--air m-btn--custom']) !!}
                <a href="{{url('admin/sub-categories')}}" type="reset"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom btn-cancel">
                    @lang('admin.sub_categories.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
@section('extra_scripts')
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
        $(document).ready(function () {
            FormControls.init()
            getSubSubCategories();
            // getItems();
            $('#category_id').change(function () {
                getSubSubCategories();
            });

            function getSubSubCategories() {
                var id = $('#category_id').val();
                $.get("{{url('admin/sub-categories/get-sub-sub-categories')}}" + '/' + id, function (data, status) {
                    $('#parent_id').children('option').remove();
                    $('#parent_id').append(new Option("{{trans('admin.items.text.sub_category')}}", 0, false, false));

                    var subCategory = data['subCategory'];

                    for (var i = 0; i < subCategory.length; i++) {
                        $('#parent_id').append(new Option(subCategory[i].name, subCategory[i].id, false, false));
                    }

                    @if(isset($subCategory))
                        var parent_id = '{{$subCategory->parent_id}}';
                        if (!parent_id)
                            parent_id = 0;
                        $('#parent_id').val(parseInt(parent_id));
                    @else
                        $('#parent_id').val(0);
                    @endif
                    $("#parent_id").trigger("chosen:updated");
                });
            };
        });

    </script>
@endsection