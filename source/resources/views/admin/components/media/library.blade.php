<div id="{{$name}}_library" class="tab-pane fade in">
    <label class="control-label">@lang('admin.media_modal.text.choose_img')</label>
    <div class="row">
        <div class="col-8 scroll-image">
            <div id="{{$name}}_image-list" class="row checkbox-section">
                @foreach($imageList as $image)
                    <div class="col-3 mt-4">
                        <img class="img-thumbnail" style="width:80px; height:80px"
                             src="{{$image->image}}"
                             alt="{{$image->size}}">
                        <p>
                            <input value="{{$image->id}}" type="checkbox" class="check-upload"
                                   name="check_upload[]">
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-4">
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
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary close_btn"
                data-dismiss="modal">@lang('admin.media_modal.button.close')</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="{{$name}}_save_image">
            @lang('admin.media_modal.button.save')
        </button>
        <button type="button" onclick="deleteImage()" class="btn btn-danger" onclick="">
            Xóa
        </button>
    </div>
</div>
