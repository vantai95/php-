
@php
$coverImg = $sectionData->data;
$dropzoneId = "dropzone-section{$sectionData->section_id}-data{$sectionData->id}";
$formId = "form-section{$sectionData->section_id}-data{$sectionData->id}";
$dataId = "data-section{$sectionData->section_id}-data{$sectionData->id}";
$uploadBtnId = "uploadbtn-section{$sectionData->section_id}-data{$sectionData->id}";
$dropzoneFiles = "{{$name}}DropzoneFiles";
@endphp

<form id="{{ $formId }}">
  <div class="row drop-zone-upload">
    <div class="col-lg-12">
      <div id="{{ $dropzoneId }}" class="dropzone">
      </div>
    </div>
    <div class="col-lg-12" style="padding-top:15px">
      <button class="btn btn-primary pull-right" id="{{ $uploadBtnId }}" type="button" name="button">Upload</button>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <hr>
    </div>
  </div>
  <div class="row slider__img-list">
    @foreach($images as $key => $img)
     <div class="col-lg-4" style="padding:5px;">
       <div class="slider__img {{ ($img->image === $coverImg) ? 'selected' : '' }}" style="height:60px;width:60px;" data-img-src="{{$img->image}}">
         <img src="{{ config('filesystems.disks.azure.url').$img->image }}" style="width: 100%;height: 100%;">
       </div>
     </div>
    @endforeach
  </div>
  <div class="row">
    <div class="col-lg-12">
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <button class="btn btn-success" type="submit" name="button">Update</button>
    </div>
  </div>
  <input type="hidden" id="{{ $dataId }}" name="data" value="{{$sectionData->data}}">
</form>

@include('admin.theme.template.script.dropzone',compact('dropzoneId','uploadBtnId'))
@include('admin.theme.template.script.form',compact('sectionData','formId'))
@include('admin.theme.template.script.cover_img',compact('formId','dataId'))
