<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

    <!-- Web fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>

        @if(app()->getLocale() == 'vi')
        WebFont.load({
            google: {"families": ["Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
        @else
        WebFont.load({
            google: {"families": ["Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
        @endif
    </script>

    <!-- Base Styles -->
    <link href="/admin-assets/theme/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="/admin-assets/theme/sites/style.bundle.css" rel="stylesheet" type="text/css"/>

    <!-- Custom Styles -->
    <link href="/admin-assets/css/app.css" rel="stylesheet" type="text/css"/>
</head>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<div class="m-grid m-grid--hor m-grid--root m-page">
    @include('admin.layouts.header')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        @include('admin.layouts.aside-left')

        <div class="m-grid__item m-grid__item--fluid m-wrapper" id="app">
            @yield('content')
        </div>
    </div>

    @include('admin.layouts.footer')
</div>

{{--@include('admin.layouts.quick-sidebar')--}}
@include('admin.layouts.scroll-top')
@include('admin.layouts.quick-nav')

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<!-- Base Scripts -->
<script src="/admin-assets/theme/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="/admin-assets/theme/sites/scripts.bundle.js" type="text/javascript"></script>

<!-- Custom Scripts -->
<script src="/admin-assets/js/app.js" type="text/javascript"></script>
<script src="/admin-assets/js/admin.js" type="text/javascript"></script>

<script type="text/javascript">
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
    @if (session('flash_message'))
    $(document).ready(function () {
        toastr.success("{{ session('flash_message') }}");
    });
    @endif

    @if (session('flash_error'))
    $(document).ready(function () {
        toastr.error("{{ session('flash_error') }}");
    });
    @endif

    $(document).ready(function() {
        $('.summernote').summernote({
            height: 170,
            followingToolbar: false
        });
        $('.select2').select2();
    });
</script>

@yield('extra_scripts')
</body>
</html>
