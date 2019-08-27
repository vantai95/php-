<script type="text/javascript">
$('#{{ $formId }}').on('click','.slider__img',function(){
  $selectedImgs = $('#{{ $formId }}').find('.slider__img.selected');
  $.each($selectedImgs,function(key,img){
    $(img).removeClass('selected');
  });
  $element = $(this);
  $element.addClass('selected');
  $('#{{ $dataId }}').val($element.data('img-src'));
})
</script>
