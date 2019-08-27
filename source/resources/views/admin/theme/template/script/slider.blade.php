<script type="text/javascript">
$('#{{ $formId }}').on('click','.slider__img',function(){
  var $element = $(this);
  if($element.hasClass('selected')){
    $element.removeClass('selected');
  }else{
    $element.addClass('selected');
  }
  $selectedImgs = $('#{{ $formId }}').find('.slider__img.selected');
  var imgArr = [];
  $.each($selectedImgs,function(key,value){
    imgArr.push($(value).data('img-src'));
  });
  $('#{{ $dataId }}').val(JSON.stringify(imgArr));
})
</script>
