@php
    $lang = Session::get('locale');
@endphp
<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-12">
            <label class="col-form-label col-lg-12 col-sm-12">
                @lang('admin.image_list.columns.image') {{ csrf_field() }}
            </label>
            <div class="col-sm-12">
                <div class="m-dropzone dropzone m-dropzone--primary" id="m-dropzone-two">
                    <div class="m-dropzone__msg dz-message needsclick">
                        <h3 class="m-dropzone__msg-title">
                            @lang('admin.image_list.text.upload_text')
                        </h3>
                    </div>
                </div>
            </div>
            {!! $errors->first('image', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success','id' => 'submitButton']) !!}
                <a href="{{url('admin/image-list')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
