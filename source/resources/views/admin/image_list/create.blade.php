@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::open(['url' => '/admin/image-list', 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true,'id' => 'submitForm']) !!}
        @include ('admin.image_list.form')
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
                Dropzone.options.mDropzoneTwo = {
                    paramName: "file",
                    maxFiles: 1,
                    init: function() {
                        this.on("maxfilesexceeded", function(file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        });
                    },
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
                }
            }
        };
        DropzoneDemo.init();
        $(document).ready(function(){
            $("#submitButton").click(function(){
                $('.items').remove();
                $('#m-dropzone-two').find('img').each(function(index){
                    $('#submitForm').append('<input type="hidden" class="items" id="img"  name="image_'+ index +'" value="'+ $(this).attr('src') +'" /> ');
                });
            });

        });

    </script>
@endsection
