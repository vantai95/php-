@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($imageList, [ 'method' => 'PATCH', 'url' => ['/admin/image-list', $imageList->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true,'id' => 'submitForm']) !!}
        @include ('admin.image_list.form', ['submitButtonText' => trans('admin.buttons.update')])
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
                    'url': "{{ url('/admin/upload-new-image') }}",

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
                            @if(!empty($imageList->image))
                                this.addCustomFile = function (file, thumbnail_url, responce) {
                                // Push file to collection

                                file.name = "{{$imageList->image}}";
                                this.files.push(file);
                                // Emulate event to create interface
                                this.emit("addedfile", file);
                                // Add thumbnail url
                                this.emit("thumbnail", file, '{{url('images/image_list/'.$imageList->image)}}');
                                // Add status processing to file
                                this.emit("processing", file);
                                // Add status success to file AND RUN EVENT success from responce
                                this.emit("success", file, responce, false);
                                // Add status complete to file
                                this.emit("complete", file);

                            }
                            this.addCustomFile(
                                // Thumbnail url
                                //"http://localhost:8000/images/items/1536742929.0.png",
                                // Custom responce for event success
                                {
                                    status: "success"
                                }
                            );
                            @endif
                    }
                }
            }
        };
        DropzoneDemo.init();

        $(document).ready(function () {
            Dropzone.autoDiscover = false;
            $("#submitButton").click(function () {
                    $('.items').remove();
                    $('#m-dropzone-two').find('img').each(function (index) {
                        $('#submitForm').append('<input type="hidden" class="items" name="image_' + $(this).attr('alt') + '" value="' + $(this).attr('src') + '" /> ');
                    });
                }
            );

        });
    </script>
@endsection
