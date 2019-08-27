<style media="screen">
  .category-meta{
    margin-left:0px;
    padding:10px 0px 5px 0px;
  }
</style>
@php
$category_metas = collect([]);
if(isset($category)){
  $category_metas = $category->category_metas;
}
@endphp

<script type="text/javascript">

var currentIndex = 0;
drawMetaList(@json($category_metas));

function addCategoryMeta(meta_data = undefined){

  var meta = {
    id: 0,
    name_en: "",
    name_vi: "",
  };

  if(meta_data !== undefined){
    meta = meta_data;
  }
  $('#category_metas').append(drawMetaFromTemplate(meta));
  currentIndex++;
}

function drawMetaList(metaList){
  var html = '';
  $.each(metaList,function(key,value){
    html += drawMetaFromTemplate(value);
    currentIndex++;
  });
  $('#category_metas').append(html);
}

function drawMetaFromTemplate(data = undefined){
  var template = `<div class="row category-meta">
    <input type="hidden" name="category_metas[`+currentIndex+`][id]" value="`+data.id+`">
    <div class="col-lg-4">
      <label>English Name</label>
      <input class="form-control m-input" type="text" name="category_metas[`+currentIndex+`][name_en]" value="`+data.name_en+`">
    </div>
    <div class="col-lg-4">
      <label>Vietnamese Name</label>
      <input class="form-control m-input" type="text" name="category_metas[`+currentIndex+`][name_vi]" value="`+data.name_vi+`">
    </div>
    <div class="col-lg-4">
      <button class="btn btn-danger pull-right" onclick="deleteCategoryMeta(this)" type="button" name="button">
        <i class="fa fa-close"></i>
      </button>
    </div>
    <div class="col-lg-12"><hr></div>
  </div>`;
  return template;
}

function deleteCategoryMeta(element){
  var $parent = $(element).parents('.category-meta');
  $parent.remove();
}

</script>
