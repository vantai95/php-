@php

  if(!isset($maxFiles)){
    $maxFiles = 100;
  }

@endphp


<div class="col-lg-{{$width}} text-nowrap {{ $errors->has('images') ? 'has-danger' : ''}}" id="image">
    <label for="images" class="col-sm-12 col-form-label">@lang('admin.media_modal.text.upload_text') </label>
    <div class="col-sm-12">
        @if(!@empty($imgList))
        <div class="row image-list" id="{{$name}}__thumb-image-list">
            @foreach($imgList as $img)
            <div class="col-2 image-col {{isset($img) ? '' : 'fade'}}">
                <img src="{{$img}}"
                    style="width: 100px;height: 100px">
                <button type="button" class="close remove-btn position-absolute {{isset($img) ? '' : 'fade'}}" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
            </div>
            @endforeach
        </div>
        @else
        <div class="row image-list" id="{{$name}}__thumb-image-list">
            <div class="col-2 image-col {{isset($imageData) ? '' : 'fade'}}">
                <img src="" style="width: 100px;height: 100px;margin-top:20px">
                <button type="button" class="close remove-btn position-absolute {{isset($imageData) ? '' : 'fade'}}" style="margin-top:20px"
                    aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
            </div>
        </div>
        @endif
        <br>
        <div id="{{$name}}_image_upload_message" class="pt-3 save-message alert alert-success alert-dismissible fade">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span class="save-message-detail"></span>
        </div>
        <div class="pt-3">
          @include('admin.components.media.popup',['name' => $name])
        </div>
        {!! $errors->first('images', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@php
$imgHidden = "";
if(empty($imgList) && $maxFiles > 1){
  $imgHidden = json_encode($imgList);
}else{
  $imgHidden = $imgList[0];
}
@endphp

<input type="hidden" value="{{$imgHidden}}" name="{{$img_name_attr}}" id="{{$name}}_image_upload">

@section('extra_scripts')
@parent
@include('admin.components.media.script',['name' => $name])
@endsection
