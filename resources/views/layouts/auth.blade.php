<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script type="text/javascript" src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- App js -->
    <script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
