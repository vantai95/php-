<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mediaModal">
    @lang('admin.media_modal.button.upload')
</button>

<!-- Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">@lang('admin.media_modal.title')</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <ul class="nav nav-tabs image-tab">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" id="upload_href"
                               href="#upload">@lang('admin.media_modal.tab.upload')</a>
                        </li>
                        <li class="nav-item image-tab">
                            <a class="nav-link" data-toggle="tab" id="library_href"
                               href="#library">@lang('admin.media_modal.tab.library')</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="upload" class="tab-pane active">
                            <div class="control-group">
                                <label class="control-label">@lang('admin.media_modal.text.upload_img')</label>
                                <div class="col-sm-12">
                                    <div class="row m-dropzone dropzone m-dropzone--primary" id="m-dropzone-two">
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
                                            data-dismiss="modal">@lang('admin.media_modal.button.close')</button>
                                    <button type="button" class="btn btn-primary"
                                            id="upload_image">@lang('admin.media_modal.button.upload')</button>
                                </div>
                            </div>
                        </div>
                        <div id="library" class="tab-pane fade in">
                            <label class="control-label">@lang('admin.media_modal.text.choose_img')</label>
                            <div class="row">
                                <div class="col-8 scroll-image">
                                    <div id="image-list" class="row checkbox-section">
                                        @foreach($imageList as $image)
                                            <div class="col-3 mt-4">
                                                <img class="img-thumbnail" style="width:80px; height:80px"
                                                     src="{{url('images/image_list/'.$image->image)}}"
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
                                    <div id="image-detail" class="fade">
                                        <img src="" id="check_upload_thumbnail"
                                             style="width:200px; height:200px">
                                        <p class="pt-3">@lang('admin.media_modal.text.img_size'):
                                            <span class="font-weight-bold" id="image_size"> </span><b> MB</b>
                                        </p>
                                        <p>@lang('admin.media_modal.text.img_name'):
                                            <span class="font-weight-bold" id="image_name"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close_btn"
                                        data-dismiss="modal">@lang('admin.media_modal.button.close')</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="save_image">
                                    @lang('admin.media_modal.button.save')
                                </button>
                                <button type="button" onclick="deleteImage()" class="btn btn-danger" onclick="">
                                    Xóa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
