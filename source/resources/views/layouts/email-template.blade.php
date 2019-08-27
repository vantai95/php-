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

</head>
<body>
@yield('content')
</body>

</html>
