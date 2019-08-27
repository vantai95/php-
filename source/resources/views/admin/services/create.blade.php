@extends('admin.layouts.app')

@section('content')

@include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

<div class="m-content">
    <div class="m-portlet">
        <!--begin::Form-->
        {!! Form::open(['url' => '/admin/services', 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' =>
        'submitForm', 'files' => true]) !!}
        @include ('admin.services.form')
        {!! Form::close() !!}
        <!--end::Form-->
    </div>
</div>
@endsection


@section('extra_scripts')
<script>

    $(function(){
      var FormControls = {
          init: function () {
              $(".user-form").validate(
                  {
                      rules: {
                          email: {required: !0, email: !0, minlength: 10},
                          full_name: {required: !0, minlength: 1},
                          phone: {required: !0, digits: !0}
                      },
                      invalidHandler: function (e, r) {
                          var i = $("#m_form_1_msg");
                          i.removeClass("m--hide").show(), mApp.scrollTo(i, -200)
                      }
                  })
          }
      };

      jQuery(document).ready(function () {
          FormControls.init()
      });

      function addImagesLibraly(imgName,imgId,imgSize) {
          const url_conf = "{{asset(config('constants.UPLOAD.IMAGE_LIST'))}}";
          $('#image-list').append(`<div class="col-3 mt-4"><img src="${url_conf}/${imgName}" alt="${imgSize}" class="img-thumbnail" style="width: 80px; height: 80px;"> <p><input value="${imgId}" type="checkbox" name="check_upload" id="check_upload" class="check-upload"></p></div>`);
      }

      function addImagesThumbLibraly(imgName,imgId,imgSize) {
          const url_conf = "{{asset(config('constants.UPLOAD.IMAGE_LIST'))}}";
          $('#image-list-thumb').append(`<div class="col-3 mt-4"><img src="${url_conf}/${imgName}" alt="${imgSize}" class="img-thumbnail" style="width: 80px; height: 80px;"> <p><input value="${imgId}" type="checkbox" name="check_upload_thumb" id="check_upload_thumb" class="check-upload-thumb"></p></div>`);
      }
    })

</script>
@endsection
