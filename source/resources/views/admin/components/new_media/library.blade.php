<div id="{{ $libraryTabId }}" class="tab-pane fade in">
    <label class="control-label">@lang('admin.media_modal.text.choose_img')</label>
    <div class="row">
        <div class="col-12 scroll-image">
            <div id="{{ $libraryImgList }}" class="row checkbox-section">
            </div>
        </div>
        <!-- <div class="col-4">
            <div id="{{$name}}_image-detail" class="fade">
                <img src="" id="{{$name}}_check_upload_thumbnail"
                     style="width:200px; height:200px">
                <p class="pt-3">@lang('admin.media_modal.text.img_size'):
                    <span class="font-weight-bold" id="{{$name}}_image_size"> </span><b> MB</b>
                </p>
                <p>@lang('admin.media_modal.text.img_name'):
                    <span class="font-weight-bold" id="{{$name}}_image_name"></span>
                </p>
            </div>
        </div> -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary close_btn"
                data-dismiss="modal">@lang('admin.media_modal.button.close')</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="{{ $saveBtnId }}">
            @lang('admin.media_modal.button.save')
        </button>
        <button id="{{ $deleteBtnId }}" type="button" class="btn btn-danger" onclick="">
            <i id="{{ $deletingId }}" style="display:none;" class="fa fa-spinner fa-spin"></i> Xóa
        </button>
    </div>
</div>
