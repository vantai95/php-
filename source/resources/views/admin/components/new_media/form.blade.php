@php

  if(!isset($max_files)){
    $max_files = 100;
  }

  $imgHidden = $imgInput;

  $libraryTabId = "{$name}_library";
  $uploadTabId = "{$name}_upload";
  $dropzoneId = "{$name}-dropzone";
  $uploadBtnId = "{$name}_upload_image";
  $saveBtnId = "{$name}_save_image";
  $thumbImageId = "{$name}__thumb-image";
  $imageUploadMsg = "{$name}_image_upload_message";
  $libraryImgList = "{$name}__library__image-list";
  $inputHiddenImg = "{$name}_image_upload";
  $deleteBtnId = "{$name}_delete_image";
  $mediaModalId = "{$name}MediaModal";
  $uploadingId = "{$name}UploadingIcon";
  $deletingId = "{$name}DeletingIcon";

  $dropzoneFiles = "{$name}DropzoneFiles";
  $libraryFiles = "{$name}LibraryFiles";

  $libraryGetDataFunc = "{$name}LibraryGetData";
  $libraryRenderFunc = "{$name}LibraryRender";
  $showThumbImgFunc = "{$name}ShowThumbImg";
  $deleteThumbImgFunc = "{$name}DeleteThumbImg";

@endphp

<div class="col-lg-{{$width}} text-nowrap {{ $errors->has('images') ? 'has-danger' : ''}}" id="image">
    <label for="images" class="col-sm-12 col-form-label">@lang($title) </label>
    <div class="col-sm-12">
        <div class="row image-list" id="{{ $thumbImageId }}">
        </div>
        <br>
        <div id="{{ $imageUploadMsg }}" class="pt-3 save-message alert alert-success alert-dismissible fade">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span class="save-message-detail"></span>
        </div>
        <div class="pt-3">
          @include('admin.components.new_media.popup',['name' => $name])
        </div>
        {!! $errors->first('images', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<input type="hidden" value="{!! $imgHidden !!}" name="{{$img_name_attr}}" id="{{ $inputHiddenImg }}">

@section('extra_scripts')
@parent
<script type="text/javascript">
  $.ajaxSetup({
    "headers":{
           'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
  });
</script>
@include('admin.components.new_media.script.dropzone')
@include('admin.components.new_media.script.form')
@include('admin.components.new_media.script.library')
@endsection
