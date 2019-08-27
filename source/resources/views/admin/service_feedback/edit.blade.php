@extends('admin.layouts.app')
@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

<div class="m-content">
    <div class="m-portlet">
        {!! Form::model($serviceFeedback, [ 'method' => 'PATCH', 'url' => ['/admin/service-feedbacks', $serviceFeedback->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true,'id' => 'submitForm']) !!}
        @include ('admin.service_feedback.form', ['submitButtonText' => trans('admin.buttons.update')])
        {!! Form::close() !!}
    </div>
</div>
@endsection


@section('extra_scripts')
    <script>
        var files_local = [];
        var token = $('input[name="_token"]').val();
        var DropzoneDemo = {
            init: function () {               
                Dropzone.options.mDropzoneTwo = {
                    paramName: "file",
                    maxFiles: 1,
                    maxFilesize: 10,
                    addRemoveLinks: !0,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    accept: function(e, o){
                        "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                    },
                    'url': "{{ url('/admin/about-us/upload') }}",

                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                    init: function () {
                        instance = this;
                        instance.on('addedfile', function(file) {
                            if (this.files[1]!=null){
                                this.removeFile(this.files[0]);
                            }
                        });
                        this.addCustomFile = function (file, thumbnail_url, responce) {
                            {{--// Push file to collection--}}

                            {{--file.name = "{{$aboutUs->image}}";--}}
                            {{--this.files.push(file);--}}
                            {{--// Emulate event to create interface--}}
                            {{--this.emit("addedfile", file);--}}
                            {{--// Add thumbnail url--}}
                            {{--this.emit("thumbnail", file, '{{url('images/abouts_us/'.$aboutUs->image)}}');--}}
                            {{--// Add status processing to file--}}
                            {{--this.emit("processing", file);--}}
                            {{--// Add status success to file AND RUN EVENT success from responce--}}
                            {{--this.emit("success", file, responce, false);--}}
                            {{--// Add status complete to file--}}
                            {{--this.emit("complete", file);--}}

                        }
                        this.addCustomFile(
                            // Thumbnail url
                            //"http://localhost:8000/images/items/1536742929.0.png",
                            // Custom responce for event success
                            {
                                status: "success"
                            }
                        );
                        this.on("addedfile", function () {
                            if (this.files[1] != null) {
                                this.removeFile(this.files[0]);
                            }
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
                    }
                }
            }
        };
        DropzoneDemo.init();

        $(document).ready(function () {
            Dropzone.autoDiscover = false;
            //get old checkbox of image
            let img_list = '{!! $checkedImageList !!}';
            $('.checkbox-section').find('img').each(function (index) {
                let img_name = $(this).attr('src').split("/").slice(-1)[0];
                if(img_list == img_name){
                    $(this).parent().find('input[type=checkbox]').prop('checked',true);
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
                    $('#check_upload_thumb').attr('src', "");
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

            // ajax post image
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

            //get image thumb when upload
            function getImageThumb() {
                let image_upload = $('#image_upload').val();
                if (image_upload) {
                    $('#image_upload_thumb').attr('src', '{{asset(config('constants.UPLOAD.IMAGE_LIST') )}}' + '/' + image_upload);
                    $('#image_upload_thumb').removeClass('fade');
                } else {
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
