<script type="text/javascript">
var {{ $dropzoneFiles }} = [];
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
         $('#pageList').trigger("change");
       }
     });
   }
 })
</script>
