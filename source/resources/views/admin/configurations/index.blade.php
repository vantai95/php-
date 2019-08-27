@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model(null, ['method' => 'POST','enctype' => 'multipart/form-data', 'url' => ['/admin/configurations'], 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.configurations.form')
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        var token = $('input[name="_token"]').val();

        $('.m-dropzone').each(function( index ) {
            let img = $(this).parent().attr('id');

            let id = $(this).attr('id');

            Dropzone.autoDiscover = false;


            var myDropzone = new Dropzone(".m-dropzone_"+id, {
                // autoDiscover : false,
                paramName: "file",
                autoProcessQueue: true,
                // uploadMultiple: true,
                // parallelUploads:3,
                acceptedFiles: "image/*",
                maxFiles: 1,
                maxFilesize: 10,
                addRemoveLinks: true,
                thumbnailWidth: null,
                thumbnailHeight: null,
                removedfile: function(file){
                    file.previewElement.remove();
                    return true;
                },
                accept: function (e, o) {
                    "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                },
                'url': "{{ url('/admin/configurations/upload') }}",
                "headers":
                    {
                        'X-CSRF-TOKEN': token
                    },

                init: function () {
                        this.addCustomFile = function (file, thumbnail_url, responce) {
                            // Push file to collection

                            file.name = img;

                            this.files.push(file);
                            // Emulate configuration to create interface
                            this.emit("addedfile", file);
                            // Add thumbnail url
                            this.emit("thumbnail", file,'{{url('/images/configurations')}}' +'/'+ img);
                            // Add status processing to file
                            this.emit("processing", file);
                            // Add status success to file AND RUN CONFIGURATION success from responce
                            this.emit("success", file, responce, false);
                            // Add status complete to file
                            this.emit("complete", file);
                        }
                    if(img != ''){
                        this.addCustomFile(

                            // Thumbnail url
                            //"http://localhost:8000/images/configurations/1536742929.0.png",
                            // Custom responce for configuration success
                            {
                                status: "success"
                            }
                        );
                    }

                }
            });

        });
        $(document).ready(function () {

            $("#submitButton").click(function () {

                    $('.configurations').remove();
                    $('.m-dropzone').each(function (index) {
                        let id = $(this).attr('id');
                        let count = $(this).find('img').length;
                        if(count == 0){
                            $('#submitForm').append('<input type="hidden" class="promotions" name="image_'+ id + '" value=" " /> ');
                        }else{
                            $(this).find('img').each(function (index) {
                                $('#submitForm').append('<input type="hidden" class="promotions" name="image_'+ id + '_' + $(this).attr('alt') + '" value="' + $(this).attr('src') + '" /> ');
                            })
                        }
                    });
                }
            )
        });
    </script>
@endsection