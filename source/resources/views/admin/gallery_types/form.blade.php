<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-labe col-sm-12">@lang('admin.gallery_types.columns.name_en') <span
                        class="text-danger">*</span></label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <label for="name_vi" class="col-form-labe col-sm-12">@lang('admin.gallery_types.columns.name_vi')</label>
            <div class="col-sm-12">
                {!! Form::text('name_vi', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_vi', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_ja') ? 'has-danger' : ''}}">
            <label for="name_ja" class="col-form-labe col-sm-12">@lang('admin.gallery_types.columns.name_ja')</label>
            <div class="col-sm-12">
                {!! Form::text('name_ja', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_ja', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-1 text-nowrap {{ $errors->has('active') ? 'has-warning' : ''}}">
            <label for="active" class="col-form-label col-sm-12">@lang('admin.gallery_types.columns.active') <span class="text-danger">*</span> </label>
        </div>
        <div class="col-lg-2 col-md-9 col-sm-12">
            <div class="m-checkbox-inline">
                <label class="m-checkbox">
                    {!! Form::checkbox('active', 1,  isset($galleryType) ? $galleryType->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                    {!! \App\Models\GalleryType::STATUS_TEXT['ACTIVE'] !!}
                    <span></span>
                </label>
            </div>
            {!! $errors->first('active', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText :trans('admin.buttons.create'), ['class' => 'btn btn-success']) !!}
                <a href="{{url('admin/gallery-types')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    <script type="text/javascript">
        //load data from selection
        $(document).ready(function () {
            getSubCategories();
            $('#category_ids').change(function () {
                getSubCategories();
            });

            function getSubCategories() {
                var id = $('#category_ids').val();
                $.get("{{url('admin/items/get-sub-categories')}}" + '/' + id, function (data, status) {
                    $('#sub_category_ids').children('option').remove();
                    for (var i = 0; i < data.length; i++) {
                        $('#sub_category_ids').append(new Option(data[i].name_en, data[i].id, false, false));
                    }
                });
            }
        })

        var FormControls={
            init:function(){
                $(".user-form").validate(
                    {
                        rules:{
                            email:{required:!0,email:!0,minlength:10},
                            full_name:{required:!0,minlength:1},
                            phone:{required:!0,digits:!0}
                        },
                        invalidHandler:function(e,r){
                            var i=$("#m_form_1_msg");
                            i.removeClass("m--hide").show(),mApp.scrollTo(i,-200)}})
            }};
        jQuery(document).ready(function(){FormControls.init()});
    </script>


@endsection
