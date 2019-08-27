<div id="{{ $uploadTabId }}" class="tab-pane active">
    <div class="control-group">
        <label class="control-label">@lang('admin.media_modal.text.upload_img')</label>
        <div class="col-sm-12">
            <div class="row m-dropzone dropzone m-dropzone--primary" id="{{ $dropzoneId }}">
                <div class="m-auto m-dropzone__msg dz-message needsclick">
                    <h3 class="m-dropzone__msg-title">
                        @lang('admin.promotions.text.upload_text')
                    </h3>
                </div>
            </div>
        </div>
        {!! $errors->first('images', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary close_btn"
                    data-dismiss="modal">
                    @lang('admin.media_modal.button.close')
                  </button>
            <button type="button" class="btn btn-primary"
                    id="{{ $uploadBtnId }}"><i id="{{ $uploadingId }}" style="display:none;" class="fa fa-spinner fa-spin"></i>@lang('admin.media_modal.button.upload')</button>
        </div>
    </div>
</div>
