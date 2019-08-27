<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ config('app.name', 'Glamer Clinic') }}</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="/common-assets/img/favicon.ico"/>

    <!-- Styles -->
    <link href="/b2c-assets/css/app.css" rel="stylesheet" type="text/css"/>
    <link href="/b2c-assets/css/vendor.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">

    <script src="/b2c-assets/js/jquery.min.js" type="text/javascript"></script>
    <script>
        // localization for Vue component
        window.trans = @php
            // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
            $lang_files = \Illuminate\Support\Facades\File::files(resource_path() . '/lang/' . \Illuminate\Support\Facades\App::getLocale());
            $trans = [];
            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename);
            }
            echo json_encode($trans);
        @endphp
    </script>
</head>
<body>
<div class="main-body">
    @include('layouts.header')

    <div style="">
        @yield('content')

        @include('layouts.footer')
    </div>
</div>

</body>
<!-- Scripts -->
<script src="/b2c-assets/js/app.js" type="text/javascript"></script>
<script src="/b2c-assets/js/vendor.js" type="text/javascript"></script>
<script type="text/javascript">
    @if (session('flash_message'))
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr.success("{{ session('flash_message') }}");
    });
    @endif

    @if (session('flash_error'))
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.error("{{ session('flash_error') }}");
    });
    @endif

</script>

<script type="text/javascript">
    $(document).ready(function(){

        $('#m_datepicker_1').datepicker({
            language: '{{\Illuminate\Support\Facades\Session::get('locale')}}',
            format: 'yyyy-mm-dd',
        });

        // $(document).ready(function () {

        window.fbAsyncInit = function() {
            FB.init({
                appId      : '1040240006156811',
                xfbml      : true,
                version    : 'v3.1'
            });
            FB.AppEvents.logPageView();
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        // })

        //online support
        $(".close-message").click(function() {
            $(".message-modal").hide();
            $("#online-support-hide").hide();
            document.cookie = "open=false";
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
                $('.online-support-form').css("bottom",$('.custom-footer').outerHeight());
            }else{
                $('.online-support-form').css("bottom","2px");
            }
        });

        $("#online-support-title").click(function() {
            $(".message-modal").show();
            $("#online-support-hide").show();
            document.cookie = "open=true";
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
                $('.online-support-form').css("bottom","2px");
            }else{
                $('.online-support-form').css("bottom","2px");
            }
        });

        setChatbox();
    });

    function setChatbox(){
        let openChat= getCookie('open');
        if(openChat == 'false'){
            $(".message-modal").hide();
            $("#online-support-hide").hide();
        }else {
            $(".message-modal").show()
            $("#online-support-hide").show();
        }
    }

    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

</script>
@yield('extra_scripts')
</html>
