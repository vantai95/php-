@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($item, [ 'method' => 'PATCH', 'url' => ['/admin/items', $item->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true,'id' => 'submitForm']) !!}
        @include ('admin.items.form', ['submitButtonText' => trans('admin.buttons.update')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        var token = $('input[name="_token"]').val();
        var DropzoneDemo = {
            init: function () {
                Dropzone.options.mDropzoneOne = {
                    paramName: "file",
                    maxFiles: 1,
                    maxFilesize: 10,
                    addRemoveLinks: true,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    removedfile: function (file) {
                        file.previewElement.remove();
                        return true;
                    },
                    accept: function (e, o) {
                        "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                    },
                    'url': "{{ url('admin/items/upload') }}",
                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                    init: function () {
                        {{--@if(!empty($item->thumb_image))--}}
                            this.addCustomFile = function (file, thumbnail_url, responce) {
                            {{--// Push file to collection--}}

                            {{--file.name = "{{$item->thumb_image}}";--}}
                            {{--this.files.push(file);--}}
                            {{--// Emulate event to create interface--}}
                            {{--this.emit("addedfile", file);--}}
                            {{--// Add thumbnail url--}}
                            {{--this.emit("thumbnail", file, '{{url('images/items/'.$item->thumb_image)}}');--}}
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
                            $('.thumb-tab li').find('a').not('.active').css('cursor', 'not-allowed');
                            $('.thumb-tab li').find('a').not('.active').addClass('disabled');
                        });
                        this.on("removedfile", function (files) {
                            if (this.files.length == 0) {
                                $('.thumb-tab li').find('a').not('.active').css('cursor', 'default');
                                $('.thumb-tab li').find('a').not('.active').removeClass('disabled');
                            }
                        });
                    }
                }
                Dropzone.options.mDropzoneTwo = {
                    paramName: "file",
                    maxFiles: 1,
                    maxFilesize: 10,
                    addRemoveLinks: true,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    removedfile: function (file) {
                        file.previewElement.remove();
                        return true;
                    },
                    accept: function (e, o) {
                        "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                    },
                    'url': "{{ url('admin/items/upload') }}",
                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                    init: function () {
                        this.addCustomFile = function (file, thumbnail_url, responce) {
                            {{--// Push file to collection--}}

                            {{--file.name = "{{$item->image}}";--}}
                            {{--this.files.push(file);--}}
                            {{--// Emulate event to create interface--}}
                            {{--this.emit("addedfile", file);--}}
                            {{--// Add thumbnail url--}}
                            {{--this.emit("thumbnail", file, '{{url('images/items/'.$item->image)}}');--}}
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
                        });
                        this.on("removedfile", function (files) {
                            if (this.files.length == 0) {
                                $('.image-tab li').find('a').not('.active').css('cursor', 'default');
                                $('.image-tab li').find('a').not('.active').removeClass('disabled');
                            }
                        });
                    }
                }
            }
        };
        DropzoneDemo.init();

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
            let firstLoad = true;
            getSubCategories();
            getSubSubCategories();
            {{--$('#sub_sub_category_id').children('option').remove();--}}
            {{--$('#sub_sub_category_id').append(new Option("{{trans('admin.items.text.sub_category')}}", 0, false, false));--}}

            $('#category_ids').change(function () {
                getSubCategories();
            });

            $('#sub_category_ids').change(function () {
                getSubSubCategories();
            });

           function getSubCategories() {
                var id = $('#category_ids').val();
                $.get("{{url('admin/items/get-sub-categories')}}" + '/' + id, function (data, status) {
                    $('#sub_category_ids').children('option').remove();
                    $('#sub_category_ids').append(new Option("{{trans('admin.items.text.sub_category')}}", 0, false, false));
                   
                    var category = data['category'];
                    var subCategory = data['subCategory'];
                    
                    if(category['type']== 1){
                        $(".sub-item-content").fadeIn();
                    }else{
                        $(".sub-item-content").fadeOut();
                    }   
                    $("#item_type").val(category['type']);
                    for (var i = 0; i < subCategory.length; i++) {
                        $('#sub_category_ids').append(new Option(subCategory[i].name, subCategory[i].id, false, false));
                    }

                    @if(isset($item))
                      
                        @if(isset($item->subCategories[0]))
                            var sub_category_id = '{{$item->subCategories[0]->id}}';
                            if (!sub_category_id)
                                sub_category_id = 0;
                            $('#sub_category_ids').val(parseInt(sub_category_id));
                        @else
                            $('#sub_category_ids').val(0);
                        @endif  
                        
                    @else
                        $('#sub_category_ids').val(0);
                    @endif
                    $("#sub_category_ids").trigger("chosen:updated");
                    
                    getSubSubCategories();
                });
            };

            function getSubSubCategories() {
                var id = $('#sub_category_ids').val();
                if(id>0){
                    $.get("{{url('admin/items/get-sub-sub-categories')}}" + '/' + id, function (data, status) {
                        
                        $('#sub_sub_category_id').children('option').remove();
                        $('#sub_sub_category_id').append(new Option("{{trans('admin.items.text.sub_category')}}", 0, false, false));

                        var subSubCategory = data['subSubCategory'];
                        for (var i = 0; i < subSubCategory.length; i++) {
                            $('#sub_sub_category_id').append(new Option(subSubCategory[i].name, subSubCategory[i].id, false, false));
                        }

                        @if(isset($item))
                            @if(isset($item->subCategories[0]))
                                var sub_sub_category_id = '{{$item->subCategories[0]->pivot->sub_sub_category_id}}';
                                if (!sub_sub_category_id)
                                    sub_sub_category_id = 0;
                                $('#sub_sub_category_id').val(parseInt(sub_sub_category_id));
                            @else
                                $('#sub_sub_category_id').val(0);
                            @endif        
                        
                        @else
                            $('#sub_sub_category_id').val(0);
                        @endif
                        $("#sub_sub_category_id").trigger("chosen:updated");

                      
                    });
                }
                
            };

            function getItems() {
                var id = $('.select-sub-item').val();
                $.get("{{url('admin/items/get-items-data')}}" + '/' + id, function (data, status) {
                    $('.sub-item-image').attr('src', '{{url(asset('images/items'))}}' + '/' + data.image);

                    $('.sub-item-price').val(data.price);
                    // $('#item_id').children('option').remove();
                    {{--$('#sub_category_ids').append(new Option("{{trans('admin.items.text.sub_category')}}", 0, false, false));--}}

                    // for (var i = 0; i < data.length; i++) {
                    //     $('#item_id').append(new Option(data[i].name_en, data[i].id, false, false));
                    // }

                    {{--@if(isset($item))--}}
                    {{--var item_id = {{$item->pluck('id')}};--}}
                    {{--if(item_id=='')--}}
                    {{--item_id = 0;--}}

                    {{--$('#item_id').val(parseInt(sub_category_ids));--}}
                    {{--@else--}}
                    {{--$('#item_id').val(0);--}}
                    {{--@endif--}}
                    {{--$("#item_id").trigger("chosen:updated");--}}

                });
            };

            // ----------Item image-----------

            //get old checkbox of image
            let img_list = '{!! $checkedImageList !!}';
            $('.checkbox-section').find('img').each(function (index) {
                let img_name = $(this).attr('src').split("/").slice(-1)[0];
                if (img_list == img_name) {
                    $(this).parent().find('input[type=checkbox]').prop('checked', true);
                }
            });

            //jquery check upload image
            $('input[type=checkbox][name=check_upload]').change(function () {
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
                let base64_image = $('.dz-image img').attr('src');
                let img_ext = $('.dz-image img').attr('alt').split(".").slice(-1)[0];
                if (base64_image) {
                    $.post("{{url('admin/upload-new-image')}}",
                        {
                            _token: "{{csrf_token()}}",
                            base64_image: base64_image,
                            img_ext: img_ext,
                        },
                        function (data, status) {
                            if (status == 'success') {
                                let html = '';
                                $(".save-message-detail").html(data.message);
                                $(".save-message").removeClass('alert-warning').addClass('alert-success').removeClass('fade').fadeOut(2000);
                                $('#image_upload').val(data.image_name);
                                getImageThumb();
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


            // ----------Item thumb image-----------
            //get old checkbox of image
            let img_thumb_list = '{!! $checkedThumbImageList !!}';
            $('.thumb-checkbox-section').find('img').each(function (index) {
                let img_thumb_name = $(this).attr('src').split("/").slice(-1)[0];
                if (img_thumb_list == img_thumb_name) {
                    $(this).parent().find('input[type=checkbox]').prop('checked', true);
                }
            });

            //jquery check upload image
            $('input[type=checkbox][name=check_upload_thumb]').change(function () {
                $('input[type="checkbox"][name=check_upload_thumb]').not(this).prop('checked', false);
                let checked = $('#check_upload_thumb:checked').length;
                let thumb_src = $('input[type=checkbox][name=check_upload_thumb]:checked').parent().parent().find('img').attr('src');
                let thumb_size = $('input[type=checkbox][name=check_upload_thumb]:checked').parent().parent().find('img').attr('alt');
                if (thumb_src) {
                    $('#thumb_check_upload_thumb').attr('src', thumb_src);
                    $('#thumb-image-detail').removeClass('fade');
                    let thumb_img_name = thumb_src.split("/").slice(-1)[0];
                    $('#thumb_image_upload').val(thumb_img_name);
                    $('#thumb_image_name').text(thumb_img_name);
                    $('#thumb_image_size').text(thumb_size);
                } else {
                    $('#thumb_check_upload_thumb').attr('src', "");
                    $('#thumb_image_upload').val('');
                    $('#thumb-image-detail').addClass('fade');
                }
                if (checked == 1) {
                    $('.thumb-tab li').find('a').not('.active').css('cursor', 'not-allowed');
                    $('.thumb-tab li').find('a').not('.active').addClass('disabled');
                } else {
                    $('.thumb-tab li').find('a').not('.active').css('cursor', 'default');
                    $('.thumb-tab li').find('a').not('.active').removeClass('disabled');
                }
            });

            //show thumb image when upload
            $('#save_thumb_image').click(function () {
                getThumbImageThumb();
            });

            //ajax post image
            $('#upload_thumb_image').click(function () {
                let base64_thumb_image = $('.dz-image img').attr('src');
                let thumb_img_ext = $('.dz-image img').attr('alt').split(".").slice(-1)[0];
                if (base64_thumb_image) {
                    $.post("{{url('admin/upload-new-thumb-image')}}",
                        {
                            _token: "{{csrf_token()}}",
                            base64_thumb_image: base64_thumb_image,
                            thumb_img_ext: thumb_img_ext
                        },
                        function (data, status) {
                            if (status == 'success') {
                                var html = '';
                                $(".thumb-save-message-detail").html(data.message);
                                $(".thumb-save-message").removeClass('alert-warning').addClass('alert-success').removeClass('fade').fadeOut(2000);
                                $('#thumb_image_upload').val(data.thumb_image_name);
                                getThumbImageThumb();
                            }
                        });
                }
                $('#thumbMediaModal').modal('toggle');

            });

            //get image thumb when upload
            function getThumbImageThumb() {
                let thumb_image_upload = $('#thumb_image_upload').val();
                if (thumb_image_upload) {
                    $('#thumb_image_upload_thumb').attr('src', '{{asset(config('constants.UPLOAD.IMAGE_LIST') )}}' + '/' + thumb_image_upload);
                    $('#thumb_image_upload_thumb').removeClass('fade');
                } else {
                    $('#thumb_image_upload_thumb').addClass('fade');
                }
            };
        });
    </script>
@endsection