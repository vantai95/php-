<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ config('app.name', 'Glamer Clinic') }}</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="/common-assets/img/favicon.ico"/>

    <!-- Base Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

    <!-- Custom Styles -->
    <link href="/admin-assets/css/app.css" rel="stylesheet" type="text/css"/>
    <style media="screen">
      .section__data{
        overflow-x:hidden;
        overflow-y:scroll;
      }
      .feature__name, .feature__detail{
        width:100%;
      }
      .feature{
        padding-top:  5px;
        /* border-bottom: 1px solid #494949; */
      }
      .feature__detail{
        padding: 5px;
      }
      .slider__img-list{
        max-height:150px;
        background:#fcfcb5;
        overflow-x:hidden;
        overflow-y:scroll;
      }
      .slider__img-list, .drop-zone-upload{
        margin-right:-5px;
        padding: 15px 10px;
      }
      hr{
        border-bottom: 1px solid #adadad;
      }
      .slider__img{
        border: 1px solid #fff;
      }
      .slider__img.selected{
        border: 2px solid #9292fc;
      }
      .drop-zone{
        margin: auto;
        min-height: 100px;
        width: 75%;
        border: 2px dashed #8985f7
      }
      #ifameMain{
        width:100%;
        height:800px;
        /* pointer-events: none; */
      }
    </style>
  </head>
  <body>
    <div class="tool-bar" style="width:30%;height:800px;position:fixed;background:#f4f2f2;">
      <div class="row">
        <div class="col-lg-12 feature">
          <select class="form-control" id="pageList" name="">
            <option value="" disabled selected>--SELECT VIEW--</option>
          </select>
        </div>
        <div id="section-list">

        </div>


      </div>
    </div>
      <div class="view-content" style="width: 70%;float: right;">
        <iframe id="ifameMain" frameborder="0" src=""></iframe>
      </div>
  </body>


<script type="text/javascript">
  var dropzoneFile = [];
  var pageList = @json($pages);
  var selectedPage = undefined;

  $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': "{{ csrf_token() }}"
      }
  });

  $(function(){
    renderPage();
  })

  function renderPage(){
    $.each(pageList,function(key,page){
      $('#pageList').append('<option value="'+page.id+'">'+page.name+'</option>')
    })
  }

  function renderSection(){
    $.ajax({
      url:"{{URL::to('/admin/theme/get-page-info')}}/" + selectedPage.id,
      type:"get",
      success:function(data){
        $('#section-list').html(data.data);
      }
    });
  }

  $('#pageList').change(function(){
    $('#section-list').html('');
    var pageId = $(this).val();
    selectedPage = pageList.find(page => page.id === Number(pageId));
    let url = "{{URL::to('/')}}/"+ selectedPage.url;
    $('#ifameMain').attr('src',url);
    renderSection();
  });


</script>
</html>
