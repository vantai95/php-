@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($service, ['method' => 'PATCH','url' => ['/admin/services', $service ->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitForm', 'files' => true]) !!}
        @include ('admin.services.form', ['submitButtonText' => @trans('admin.services.buttons.update')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>

        function selectSubItem(e) {
            var parent = $(this).parents().html();
            parent = $(event.target).parents('.form-group');
            var id = e.value;
            $.get("{{url('admin/items/get-items-data')}}" + '/' + id, function (data, status) {
                parent.find('.sub-item-image').attr('src', '{{url(asset('images/items'))}}' + '/' + data.image);
                parent.find('.sub-item-price').val(data.price);
            });
        };

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


        function addImagesLibraly(imgName,imgId,imgSize) {
            const url_conf = "{{asset(config('constants.UPLOAD.IMAGE_LIST'))}}";
            $('#image-list').append(`<div class="col-3 mt-4"><img src="${url_conf}/${imgName}" alt="${imgSize}" class="img-thumbnail" style="width: 80px; height: 80px;"> <p><input value="${imgId}" type="checkbox" name="check_upload" id="check_upload" class="check-upload"></p></div>`);
        }

        function addImagesThumbLibraly(imgName,imgId,imgSize) {
            const url_conf = "{{asset(config('constants.UPLOAD.IMAGE_LIST'))}}";
            $('#image-list-thumb').append(`<div class="col-3 mt-4"><img src="${url_conf}/${imgName}" alt="${imgSize}" class="img-thumbnail" style="width: 80px; height: 80px;"> <p><input value="${imgId}" type="checkbox" name="check_upload_thumb" id="check_upload_thumb" class="check-upload-thumb"></p></div>`);
        }
      });
    </script>
@endsection
