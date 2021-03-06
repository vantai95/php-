<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#thumbMediaModal">
    @lang('admin.media_modal.button.upload')
</button>

<!-- Modal -->
<div class="modal fade" id="thumbMediaModal" tabindex="-1" role="dialog" aria-labelledby="thumbMediaModalLabel"
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
                    <ul class="nav nav-tabs thumb-tab">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab"
                               href="#uploadThumb">@lang('admin.media_modal.tab.upload')</a>
                        </li>
                        <li class="nav-item thumb-tab">
                            <a class="nav-link thumb-tab" data-toggle="tab"
                               href="#thumbLibrary">@lang('admin.media_modal.tab.library')</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="uploadThumb" class="tab-pane active">
                            <div class="control-group">
                                <label class="control-label">@lang('admin.media_modal.text.upload_img')</label>
                                <div class="col-sm-12">
                                    <div class="m-dropzone dropzone m-dropzone--primary" id="m-dropzone-one">
                                        <div class="m-dropzone__msg dz-message needsclick">
                                            <h3 class="m-dropzone__msg-title">
                                                @lang('admin.promotions.text.upload_text')
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                {!! $errors->first('images', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">@lang('admin.media_modal.button.close')</button>
                                    <button type="button" class="btn btn-primary"
                                            id="upload_thumb_image">@lang('admin.media_modal.button.upload')</button>
                                </div>
                            </div>
                        </div>
                        <div id="thumbLibrary" class="tab-pane fade in">
                            <label class="control-label">@lang('admin.media_modal.text.choose_img')</label>
                            <div class="row">
                                <div class="col-8 scroll-image">
                                    <div id="image-list-thumb" class="row thumb-checkbox-section">
                                        @foreach($imageList as $image)
                                            <div class="col-3 mt-4">
                                                <img class="img-thumbnail" style="width:80px; height:80px"
                                                     src="{{url('images/image_list/'.$image->image)}}"
                                                     alt="{{$image->size}}">
                                                <p>
                                                    <input value="{{$image->id}}" type="checkbox" class="check-upload-thumb"
                                                           name="check_upload_thumb" id="check_upload_thumb">
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div id="thumb-image-detail" class="fade">
                                        <img src="" id="thumb_check_upload_thumb"
                                             style="width:200px; height:200px">
                                        <p class="pt-3">@lang('admin.media_modal.text.img_size'):
                                            <span class="font-weight-bold" id="thumb_image_size"> </span><b> MB</b>
                                        </p>
                                        <p>@lang('admin.media_modal.text.img_name'):
                                            <span class="font-weight-bold" id="thumb_image_name"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">@lang('admin.media_modal.button.close')</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="save_thumb_image">
                                    @lang('admin.media_modal.button.save')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




