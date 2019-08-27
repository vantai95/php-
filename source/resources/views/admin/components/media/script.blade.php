<script>
    var {{$name}}_files_local = [];
    var DropzoneDemo = {
        init: function () {
            Dropzone.options.{{$name}}Dropzone = {
                @if(isset($maxFile))
                  maxFiles: {{$maxFile}}
                @endif
                paramName: "file",
                // maxFiles: 14,
                maxFilesize: 10,
                addRemoveLinks: !0,
                thumbnailWidth: null,
                thumbnailHeight: null,

                accept: function (e, o) {
                    "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o()
                },
                'url': "{{ url('/admin/galleries/upload') }}",

                "headers":
                    {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                init: function () {
                    this.on("addedfiles", function (files) {
                        {{$name}}_files_local = this.files;
                        const files_length = this.files.length;
                        if (files_length > "{{config('constants.MAX_FILE_UPLOAD')}}" ) {
                            {{--alert( "{{config('constants.MAX_FILE_UPLOAD')}}" );--}}
                            for (i = 0; i < files_length - "{{config('constants.MAX_FILE_UPLOAD')}}" ; i++) {
                                this.removeFile(files[i]);
                            }
                            alert('No more {{ config('constants.MAX_FILE_UPLOAD') }} files please!');
                        }
                    });
                    this.on("removedfile", function () {
                        {{$name}}_files_local = this.files;
                    });
                }
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
        let {{$name}}_img_list = [];

        //jquery check upload image
        $("#{{$name}}_image-list").on('click',"input[type=checkbox][name='check_upload[]']",function () {
            let checked_length = $('#check_upload:checked').length;
            let src = $(this).parent().parent().find('img').attr('src');
            let size = $(this).parent().parent().find('img').attr('alt');
            if (src) {
                $('#{{$name}}_check_upload_thumbnail').attr('src', src);
                $('#{{$name}}_image-detail').removeClass('fade');
                let img_name = src;
                let checked = img_name;
                if ($(this).is(':checked')) {
                    {{$name}}_img_list.push(checked);
                } else {
                    {{$name}}_img_list.splice($.inArray(checked, {{$name}}_img_list), 1);
                }
                // showImagesUploaded({{$name}}_img_list);
                $('#{{$name}}_image_name').text(img_name);
                $('#{{$name}}_image_size').text(size);
            } else {
                $('#{{$name}}_check_upload_thumbnail').attr('src', "");
                $('#{{$name}}_image-detail').addClass('fade');
            }
        });

        //show thumb image when upload
        $('#{{$name}}_save_image').click(function () {
            if({{$name}}_files_local.length) {
                let formData = new FormData();
                $.each({{$name}}_files_local,function(i,file){
                    formData.append('files[]',file);
                });
                formData.append('_token',"{{csrf_token()}}");
                $.ajax({
                    url:"{{url('admin/upload-image-list')}}",
                    data: formData,
                    type: 'post',
                    contentType: false,
                    processData: false,
                    success: function (data, status) {
                        var html = '';
                        $("#{{$name}}_image_upload_message").html(data.message);
                        $("#{{$name}}_image_upload_message").removeClass('alert-warning').addClass('alert-success').removeClass('fade').fadeOut(2000);
                        for(let i = 0; i < data.image_name.length; i++){
                            {{$name}}_img_list.push(data.image_name[i]);
                        }
                        {{$name}}ImagesUploaded({{$name}}_img_list);
                        getImagesThumb();
                        addImagesLibraly(data.image_name,data.image_id,data.image_size);
                        // reset files
                        {{$name}}_files_local = [];
                        const myDropzone = Dropzone.forElement("#{{$name}}-dropzone");
                        myDropzone.removeAllFiles(true);
                    }
                });
            }
            {{$name}}ImagesUploaded({{$name}}_img_list);
            getImagesThumb();
        });


        //ajax post image
        $('#{{$name}}_upload_image').click(function () {
            if({{$name}}_files_local.length) {
                let formData = new FormData();
                $.each({{$name}}_files_local,function(i,file){
                    formData.append('files[]',file);
                });
                formData.append('_token',"{{csrf_token()}}");
                $.ajax({
                    url:"{{url('admin/upload-image-list')}}",
                    data: formData,
                    type: 'post',
                    contentType: false,
                    processData: false,
                    success: function (data, status) {
                        var html = '';
                        $("#{{$name}}_image_upload_message").html(data.message);
                        $("#{{$name}}_image_upload_message").removeClass('alert-warning').addClass('alert-success').removeClass('fade').fadeOut(2000);
                        for(let i = 0; i < data.image_name.length; i++){
                            {{$name}}_img_list.push(data.image_name[i]);
                        }
                        {{$name}}ImagesUploaded({{$name}}_img_list);
                        getImagesThumb();
                        addImagesLibraly(data.image_name,data.image_id,data.image_size);

                        // reset files
                        {{$name}}_files_local = [];
                        const myDropzone = Dropzone.forElement("#{{$name}}-dropzone");
                        myDropzone.removeAllFiles(true);
                    }
                });
            }
            $('#{{$name}}MediaModal').modal('toggle');

        });


        //show image thumb when upload
        function getImagesThumb() {
          $('#{{$name}}__thumb-image-list').html('');
          @if($maxFiles > 1)
            let image_upload_data = eval($('#{{$name}}_image_upload').val());
            $.each(eval($('input#{{$name}}_image_upload').val()), function () {
                $('#{{$name}}__thumb-image-list').append("<div class='col-2 image-col'>"
                    + "<img style='width: 100px; height: 100px;margin-top:20px' src=" + this + '>'
                    + " <button type='button' style='margin-top:20px;' aria-label='Close' class='close remove-btn position-absolute'><span aria-hidden='true'>×</span></button>"
                    + "</div>");
            });
            @else
              let image_upload_data = $('#{{$name}}_image_upload').val();
              $('#{{$name}}__thumb-image-list').append("<div class='col-2 image-col'>"
                  + "<img style='width: 100px; height: 100px;margin-top:20px' src=" + image_upload_data + '>'
                  + " <button type='button' style='margin-top:20px;' aria-label='Close' class='close remove-btn position-absolute'><span aria-hidden='true'>×</span></button>"
                  + "</div>");
            @endif
            // handle event elements
            $(".close.remove-btn").each(function () {
                $(this).on("click", function () {
                    let src = $(this).siblings("img").attr('src');
                    let img_name = src.split("/").slice(-1)[0];
                    {{$name}}_img_list.splice({{$name}}_img_list.indexOf(img_name), 1);
                    $(this).closest("div").remove();
                    {{$name}}ImagesUploaded({{$name}}_img_list);
                    if ({{$name}}_img_list.length == 0) {
                        $('.image-tab li').find('a').not('.active').css('cursor', 'default');
                        $('.image-tab li').find('a').not('.active').removeClass('disabled');
                    }
                    $("img[src='" + src + "']").parent().find("input[type=checkbox][name='check_upload[]']:checked").prop('checked', false);
                });
            });
        };

        function addImagesLibraly(imgList,imgListId,imgSize) {
            $.each(imgList, function (i,src) {
                $('#{{$name}}_image-list').append(`<div class="col-3 mt-4"><img src="${src}" alt="${imgSize[i]}" class="img-thumbnail" style="width: 80px; height: 80px;"> <p><input value="${imgListId[i]}" type="checkbox" name="check_upload[]" id="check_upload" class="check-upload" checked="checked"></p></div>`);
            });
        }

        function {{$name}}ImagesUploaded({{$name}}_img_list){
          console.log({{$name}}_img_list);
          $('#{{$name}}_image_upload').val(
            @if($maxFiles > 1)
            JSON.stringify({{$name}}_img_list)
            @else
            {{$name}}_img_list
            @endif
          );
        }

        //close modal
        $('.close_btn').click(function () {
            $('.checkbox-section').find('input').prop('checked', false);
            $('#{{$name}}_image_upload').val('');
            {{$name}}_img_list = [];
            $('.image-list').find('div').remove();
            $('.image-tab li').find('a').not('.active').css('cursor', 'default');
            $('.image-tab li').find('a').not('.active').removeClass('disabled');
        });


    });

</script>
