<script type="text/javascript">

  $(function(){
    {{ $showThumbImgFunc }}();
  });

  function {{ $showThumbImgFunc }}(){
    $('#{{ $thumbImageId }}').html('');

    @if($max_files > 1)
      var imgs = JSON.parse($('#{{ $inputHiddenImg }}').val());
      $.each(imgs, function(key, img){
        $('#{{ $thumbImageId }}').append("<div class='col-6 image-col'>"
            + "<img style='width: 100px; height: 100px;margin-top:20px' src={{ config('filesystems.disks.azure.url') }}" + img + '>'
            + " <button type='button' style='margin-top:20px;' onclick='{{ $deleteThumbImgFunc }}(`"+img+"`)' aria-label='Close' class='close remove-btn position-absolute'><span aria-hidden='true'>×</span></button>"
            + "</div>");
      });
    @else
      var img = $('#{{ $inputHiddenImg }}').val();
      if(img !== ""){
        $('#{{ $thumbImageId }}').append("<div class='col-6 image-col'>"
            + "<img style='width: 100px; height: 100px;margin-top:20px' src={{ config('filesystems.disks.azure.url') }}" + img + '>'
            + " <button type='button' style='margin-top:20px;' onclick='{{ $deleteThumbImgFunc }}(`"+img+"`)' aria-label='Close' class='close remove-btn position-absolute'><span aria-hidden='true'>×</span></button>"
            + "</div>");
      }
    @endif
    $('#{{ $mediaModalId }}').modal("hide");
  }

  function {{ $deleteThumbImgFunc }}(src) {
    @if($max_files > 1)
      var imgs = JSON.parse($('#{{ $inputHiddenImg }}').val());
      imgs = imgs.filter(img => img !== src);
      $('#{{ $inputHiddenImg }}').val(JSON.stringify(imgs));
    @else
      $('#{{ $inputHiddenImg }}').val('');
    @endif
    {{ $showThumbImgFunc }}();
    {{ $libraryGetDataFunc }}();
  }

</script>
