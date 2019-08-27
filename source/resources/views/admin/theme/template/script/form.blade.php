<script type="text/javascript">
$('#{{ $formId }}').submit(function(e){
  e.preventDefault();
  var data = $(this).serializeArray();
  $.ajax({
    url: "{{ url('/admin/theme/update-section-data/') }}/" + {{$sectionData->id}},
    type: "post",
    data: data,
    success:function(response){
      $('#pageList').trigger("change");
    }
  });
})
</script>
