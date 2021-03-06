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

    <!-- Fonts -->
    <link href="/b2c-assets/fonts/myriad-pro/Myriad Pro Bold SemiExtended.ttf" rel="stylesheet"
          type="text/css">
    <link href="/b2c-assets/fonts/alphabetized_cassette_tapes/Alphabetized Cassette Tapes.ttf"
          rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="/b2c-assets/css/app.css" rel="stylesheet">
</head>
<body>
<div>
    <div class="container">
        @yield('content')
    </div>
</div>
</body>
<!-- Scripts -->
<script src="/b2c-assets/js/app.js"></script>
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
@yield('extra_scripts')
</html>
