@php
    $lang = Session::get('locale');
@endphp
@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::open(['url' => '/admin/promotions', 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitForm', 'files' => true]) !!}
        @include ('admin.promotions.form')
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        $('#m_datepicker_1').datepicker({
            language: '{{$lang}}',
            format: 'yyyy-mm-dd'
        });

        $('#m_datepicker_2').datepicker({
            language: '{{$lang}}',
            format: 'yyyy-mm-dd'
        });
        var files_local = [];
        var token = $('input[name="_token"]').val();
        var DropzoneDemo = {
            init: function () {
                Dropzone.options.mDropzoneTwo = {
                    paramName: "file",
                    maxFiles: 1,
                    init: function () {
                        this.on("maxfilesexceeded", function (file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        });
                        this.on("addedfile", function (files) {
                            $('.image-tab li').find('a').not('.active').css('cursor', 'not-allowed');
                            $('.image-tab li').find('a').not('.active').addClass('disabled');
                            files_local = this.files;
                        });
                        this.on("removedfile", function (files) {
                            if (this.files.length == 0) {
                                $('.image-tab li').find('a').not('.active').css('cursor', 'default');
                                $('.image-tab li').find('a').not('.active').removeClass('disabled');
                            }
                            files_local = this.files;
                        });
                        this.on("success", function(files){
                            let base64_img_code = $('.dz-image img').attr('src').split(',')[1];
                            let img_ext =  $('.dz-image img').attr('alt').split(".").slice(-1)[0];
                            if(img_ext == 'jpg'){
                                let base64_image_ext = 'data:image/jpg;base64';
                                $('.dz-image img').attr('src',base64_image_ext + ',' + base64_img_code);
                            }else if(img_ext == 'jpeg'){
                                let base64_image_ext = 'data:image/jpeg;base64';
                                $('.dz-image img').attr('src',base64_image_ext + ',' + base64_img_code);
                            }else{
                                let base64_image_ext = 'data:image/png;base64';
                                $('.dz-image img').attr('src',base64_image_ext + ',' + base64_img_code);
                            }
                        })
                    },
                    maxFilesize: 10,
                    addRemoveLinks: !0,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    accept: function (e, o) {
                        "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                    },
                    'url': "{{ url('/admin/promotions/upload') }}",

                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                }
            }
        };
        DropzoneDemo.init();

        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //jquery check upload image
            $("#image-list").on('click',"input[type=checkbox][name='check_upload']",function () {
                $('input[type="checkbox"][name=check_upload]').not(this).prop('checked', false);
                let checked = $('#check_upload:checked').length;
                let src = $('input[type=checkbox][name=check_upload]:checked').parent().parent().find('img').attr('src');
                let size = $('input[type=checkbox][name=check_upload]:checked').parent().parent().find('img').attr('alt');
                if (src) {
                    $('#check_upload_thumbnail').attr('src', src);
                    $('#image-detail').removeClass('fade');
                    let img_name = src.split("/").slice(-1)[0];
                    $('#image_upload').val(img_name);
                    $('#image_name').text(img_name);
                    $('#image_size').text(size);
                } else {
                    $('#check_upload_thumbnail').attr('src', "");
                    $('#image_upload').val('');
                    $('#image-detail').addClass('fade');
                }
                if (checked == 1) {
                    $('.image-tab li').find('a').not('.active').css('cursor', 'not-allowed');
                    $('.image-tab li').find('a').not('.active').addClass('disabled');
                } else {
                    $('.image-tab li').find('a').not('.active').css('cursor', 'default');
                    $('.image-tab li').find('a').not('.active').removeClass('disabled');
                }
            });

            //show thumb image when upload
            $('#save_image').click(function () {
                getImageThumb();
            });

            //ajax post image
            $('#upload_image').click(function () {
                if (files_local.length) {
                    let formData = new FormData();
                    formData.append('image',files_local[0]);
                    formData.append('_token',"{{csrf_token()}}");
                    $.ajax({
                        url: "{{url('admin/upload-new-image')}}",
                        data: formData,
                        type: 'post',
                        contentType: false,
                        processData: false,
                        success: function (data, status) {
                            if (status == 'success') {
                                let html = '';
                                $(".save-message-detail").html(data.message);
                                $(".save-message").removeClass('alert-warning').addClass('alert-success').removeClass('fade').fadeOut(2000);
                                $('#image_upload').val(data.image_name);
                                getImageThumb();
                                addImagesLibraly(data.image_name,data.image_id,data.image_size);

                                files_local = [];
                            }
                        }
                    });
                }
                $('#mediaModal').modal('toggle');
            });

            //show image thumb when upload
            function getImageThumb() {
                let image_upload =  $('#image_upload').val();
                if(image_upload){
                    $('#image_upload_thumb').attr('src', '{{asset(config('constants.UPLOAD.IMAGE_LIST') )}}' + '/' + image_upload);
                    $('#image_upload_thumb').removeClass('fade');
                }else{
                    $('#image_upload_thumb').addClass('fade');
                }
            };

            function addImagesLibraly(imgName,imgId,imgSize) {
                const url_conf = "{{asset(config('constants.UPLOAD.IMAGE_LIST'))}}";
                $('#image-list').append(`<div class="col-3 mt-4"><img src="${url_conf}/${imgName}" alt="${imgSize}" class="img-thumbnail" style="width: 80px; height: 80px;"> <p><input value="${imgId}" type="checkbox" name="check_upload" id="check_upload" class="check-upload"></p></div>`);
            }
        });
    </script>
@endsection
