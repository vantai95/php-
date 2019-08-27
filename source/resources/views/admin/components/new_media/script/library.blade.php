<script type="text/javascript">
  var {{ $libraryFiles }}  = [];
  $(function(){
    {{ $libraryGetDataFunc }}();
  });

  function {{ $libraryGetDataFunc }}(){
    $.ajax({
      url: '{{ url("admin/get-img-list") }}',
      type: 'get',
      success:function(response){
        {{ $libraryFiles }} = response.data;
        {{ $libraryRenderFunc }}();
      }
    });
  }

  function {{ $libraryRenderFunc }}(){
    $('#{{ $libraryImgList }}').html('');
    @if($max_files > 1)
      var selectedImgs = JSON.parse($('#{{ $inputHiddenImg }}').val());
      $.each({{ $libraryFiles }},function(key,img){
        var selected = (selectedImgs.includes(img)) ? 'selected' : '';
        var html = `<div class="col-3 mt-4">`;
        html += `<img class="img-thumbnail library-img `+ selected +`" data-img-src="`+img.image+`" style="width:80px; height:80px"`;
        html += `src="{{ config('filesystems.disks.azure.url')}}`+img.image+`"
             alt="Image">
             </div>`;
             $("#{{ $libraryImgList }}").append(html);
      });
    @else
      var selectedImg = $('#{{ $inputHiddenImg }}').val();
      $.each({{ $libraryFiles }},function(key,img){
        var selected = (selectedImg === img.image) ? 'selected' : '';
        var html = `<div class="col-3 mt-4">`;
        html += `<img class="img-thumbnail library-img `+ selected +`" data-img-src="`+img.image+`" style="width:80px; height:80px"`;
        html += `src="{{ config('filesystems.disks.azure.url')}}`+img.image+`"
             alt="Image">
             </div>`;
             $("#{{ $libraryImgList }}").append(html);
      });
    @endif
  }

  $('#{{ $libraryImgList }}').on('click','.library-img',function(){
    @if($max_files > 1)
      var $img = $(this);
      if($img.hasClass('selected')){
        $img.removeClass('selected');
      }else{
        $img.addClass('selected');
      }
    @else
      $selectedImgs = $('#{{ $libraryImgList }}').find('.library-img.selected');
      $.each($selectedImgs,function(key,img){
        $(img).removeClass('selected');
      });
      $img = $(this);
      $img.addClass('selected');

    @endif
  });

  $('#{{ $saveBtnId }}').click(function(){
    @if($max_files > 1)
      var imgList = $('#{{ $libraryImgList }}').find('.library-img.selected');
      var imgArr = [];
      $.each(imgList,function(key,img){
        var imgSrc = $(img).data('img-src');
        imgArr.push(imgSrc);
      });
      $('#{{ $inputHiddenImg }}').val(JSON.stringify(imgArr));
    @else
      var $selectedImg = $('#{{ $libraryImgList }}').find('.library-img.selected').first();
      var imgSrc = $selectedImg.data('img-src');
      $('#{{ $inputHiddenImg }}').val(imgSrc);
    @endif

    {{ $showThumbImgFunc }}();
  });

  $('#{{ $deleteBtnId }}').click(function(){
    var selectedImgs = $('#{{ $libraryImgList }}').find('.library-img.selected');
    $('#{{ $deletingId }}').show();

    setTimeout(function(){
      var imgArr = [];
      $.each(selectedImgs, function(key,img){
        var src = $(img).data('img-src');
        imgArr.push(src);
      });

      $.ajax({
        url:"{{ url('admin/delete-images') }}",
        type: "post",
        data: {
          'imagesToDelete' : imgArr
        },
        success : function(response){
          {{ $libraryGetDataFunc }}();
          $('#{{ $deletingId }}').hide();
          @if($max_files > 1)
            var thumbImgs = JSON.parse($('#{{ $inputHiddenImg }}').val());
            thumbImgs = thumbImgs.filter(img => !imgArr.includes(img));
            $('#{{ $inputHiddenImg }}').val(JSON.stringify(thumbImgs));
          @else
            var thumbImg = $('#{{ $inputHiddenImg }}').val();
            if(imgArr.includes(thumbImg)){
                $('#{{ $inputHiddenImg }}').val('');
            }
          @endif
          {{ $showThumbImgFunc }}();
        }
      });
    },300);


  });
</script>
