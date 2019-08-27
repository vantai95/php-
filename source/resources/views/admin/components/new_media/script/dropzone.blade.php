<script type="text/javascript">
  var {{ $dropzoneFiles }} = [];
  Dropzone.autoDiscover = false;
 $('#{{ $dropzoneId }}').dropzone({
   paramName: "file",
   maxFilesize: 10,
   addRemoveLinks: !0,
   thumbnailWidth: null,
   thumbnailHeight: null,
   "url":"{{ url('/admin/galleries/upload') }}",
   "headers":{
           'X-CSRF-TOKEN': "{{csrf_token()}}"
    },
    init : function(){
      this.on("addedfile",function(file){
        {{ $dropzoneFiles }} = this.files;
      });
      this.on("removedfile", function () {
        {{ $dropzoneFiles }} = this.files;
      });
    }
 });

 $('#{{ $uploadBtnId }}').click(function(){
   var fd = new FormData();

   $("#{{ $uploadingId }}").show();
   setTimeout(function(){
     $.each({{ $dropzoneFiles }},function(key,file){
       fd.append('files[]',file);
     });

     if({{ $dropzoneFiles }}.length > 0){
       $.ajax({
         url:"{{url('admin/upload-image-list')}}",
         data: fd,
         type: 'post',
         contentType: false,
         processData: false,
         success:function(response){
           $("#{{ $uploadingId }}").hide();
           {{ $libraryGetDataFunc }}();
           @if($max_files > 1)
              $('#{{ $inputHiddenImg }}').val(JSON.stringify(response.uploaded_image_list));
           @else
              $('#{{ $inputHiddenImg }}').val(response.uploaded_image_list[0]);
           @endif
           {{ $showThumbImgFunc }}();
         }
       });
     }
   }, 300);

 })
</script>
