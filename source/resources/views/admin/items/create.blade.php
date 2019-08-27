@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::open(['url' => '/admin/items', 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true,'id' => 'submitForm']) !!}
        @include ('admin.items.form')
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>

@endsection

@section('extra_scripts')
    <script>

        var token = $('input[name="_token"]').val();
        var DropzoneDemo = {
            init: function(){

                Dropzone.options.mDropzoneOne = {
                    paramName: "file",
                    maxFiles: 1,
                    init: function() {
                        this.on("maxfilesexceeded", function(file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        });
                        this.on("addedfile", function (files) {
                            var arr = this.files;
                            console.log("AAAAAAAAAAAAAAA");
                            console.log(this.files);
                            $('.thumb-tab li').find('a').not('.active').css('cursor', 'not-allowed');
                            $('.thumb-tab li').find('a').not('.active').addClass('disabled');
                        });
                        this.on("removedfile", function (files) {
                            if (this.files.length == 0) {
                                $('.thumb-tab li').find('a').not('.active').css('cursor', 'default');
                                $('.thumb-tab li').find('a').not('.active').removeClass('disabled');
                            }
                        });
                    },
                    maxFilesize: 10,
                    addRemoveLinks: !0,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    accept: function(e, o){
                        "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                    },
                    'url': "{{ url('/admin/items/upload') }}",

                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                }
                Dropzone.options.mDropzoneTwo = {
                    paramName: "file",
                    maxFiles: 1,
                    init: function() {
                        this.on("maxfilesexceeded", function(file) {
                            this.removeAllFiles();
                            this.addFile(file);
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
                    },
                    maxFilesize: 10,
                    addRemoveLinks: !0,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    accept: function(e, o){
                        "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                    },
                    'url': "{{ url('/admin/items/upload') }}",

                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                }
            }
        };
        DropzoneDemo.init();

        function selectSubItem(e){
            var parent =$(this).parents().html();
            parent = $( event.target ).parents('.form-group');
            var id = e.value;
            $.get("{{url('admin/items/get-items-data')}}" + '/' + id, function (data, status) {
                parent.find('.sub-item-image').attr('src','{{url(asset('images/items'))}}'+ '/' + data.image);
                parent.find('.sub-item-price').val(data.price);
            });
        }

        $(document).ready(function(){
            $('#sub_sub_category_id').children('option').remove();
            $('#sub_sub_category_id').append(new Option("{{trans('admin.items.text.sub_category')}}", 0, false, false));
            getSubCategories();
            getSubSubCategories();
            // getItems();
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
                    getSubSubCategories();
                });
            };

            function getSubSubCategories() {
                var id = $('#sub_category_ids').val();
                $.get("{{url('admin/items/get-sub-sub-categories')}}" + '/' + id, function (data, status) {
                    $('#sub_sub_category_id').children('option').remove();
                    $('#sub_sub_category_id').append(new Option("{{trans('admin.items.text.sub_category')}}", 0, false, false));

                    var subSubCategory = data['subSubCategory'];

                    for (var i = 0; i < subSubCategory.length; i++) {
                        $('#sub_sub_category_id').append(new Option(subSubCategory[i].name, subSubCategory[i].id, false, false));
                    }
                });
            };

            function getItems() {
                var id = $('.select-sub-item').val();
                $.get("{{url('admin/items/get-items-data')}}" + '/' + id, function (data, status) {
                    $('.sub-item-image').attr('src','{{url('images/items')}}'+ '/' + data.image);

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
            // jquery check upoad image
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
                let img_ext =  $('.dz-image img').attr('alt').split(".").slice(-1)[0];
                if (base64_image) {
                    $.post("{{url('admin/upload-new-image')}}",
                        {
                            _token: "{{csrf_token()}}",
                            base64_image: base64_image,
                            img_ext: img_ext,
                        },
                        function (data, status) {
                            if (status == 'success') {
                                var html = '';
                                $(".save-message-detail").html(data.message);
                                $(".save-message").removeClass('alert-warning').addClass('alert-success').removeClass('fade').fadeOut(2000);
                                $('#image_upload').val(data.image_name);
                                getImageThumb();
                            }
                        });
                }
                $('#mediaModal').modal('toggle');

            });

            //show thumb image when upload
            function getImageThumb() {
                let image_upload =  $('#image_upload').val();
                if(image_upload){
                    $('#image_upload_thumb').attr('src', '{{asset(config('constants.UPLOAD.IMAGE_LIST') )}}' + '/' + image_upload);
                    $('#image_upload_thumb').removeClass('fade');
                }else{
                    $('#image_upload_thumb').addClass('fade');
                }
            };

            // ----------Item thumb image-----------
            // jquery check upoad thumb image
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
                let thumb_img_ext =  $('.dz-image img').attr('alt').split(".").slice(-1)[0];
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

            //show image thumb when upload
            function getThumbImageThumb() {
                let thumb_image_upload =  $('#thumb_image_upload').val();
                if(thumb_image_upload){
                    $('#thumb_image_upload_thumb').attr('src', '{{asset(config('constants.UPLOAD.IMAGE_LIST') )}}' + '/' + thumb_image_upload);
                    $('#thumb_image_upload_thumb').removeClass('fade');
                }else{
                    $('#thumb_image_upload_thumb').addClass('fade');
                }
            };

        });

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
    </script>
@endsection
