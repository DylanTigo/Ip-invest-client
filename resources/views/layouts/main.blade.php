<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/summernote@latest/dist/summernote-bs4.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    @yield('style')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>

<body data-sidebar="dark" data-topbar="dark">

    <div id="layout-wrapper">

        @include('partials.header')

        @include('partials.sidebar')

        @yield('content')

    </div>


    <!-- JAVASCRIPT -->
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@latest/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    {{-- <script type="text/javascript" src="https://js.pusher.com/7.0/pusher.min.js"></script> --}}

    @yield('script')
    <script type="text/javascript">
        window.user = {
            id: {{ optional(auth()->user())->id }}
        }

        var observe;
        var text = document.getElementById('autoresize');

        function redirectTo(url) {
            window.location.assign(url);
        }

        function goBack() {
            window.history.back();
        }

        function resetFilters() {
            $('input[name="start_date"]').val('');
            $('input[name="end_date"]').val('');
            $('select[name="status"]').val('');
            $('select[name="avancement"]').val('');
            $('select[name="secteur"]').val('');
            document.getElementById('filterForm').submit();
        }

        function reload() {
            window.location.reload();
        }

        function resize() {
            text.style.height = 'auto';
            text.style.height = text.scrollHeight + 'px';
        }

        function delayedResize() {
            window.setTimeout(resize, 0);
        }

        function init() {
            if (window.attachEvent) {
                observe = function(element, event, handler) {
                    if (element) {
                        element.attachEvent('on' + event, handler);
                    }
                };
            } else {
                observe = function(element, event, handler) {
                    if (element) {
                        element.addEventListener(event, handler, false);
                    }
                };
            }

            if (text) {
                observe(text, 'change', resize);
                observe(text, 'cut', delayedResize);
                observe(text, 'paste', delayedResize);
                observe(text, 'drop', delayedResize);
                observe(text, 'keydown', delayedResize);

                text.focus();
                text.select();
                resize();
            }
        }

        $(document).ready(function() {

            $("#flip").click(function() {
                $("#panel").slideDown("slow");
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            init();

            $('#summernote').summernote({
                minHeight: 150
            });

            $('#summernote1').summernote({
                minHeight: 150
            });
            
            $('#exampleFormControlTextarea1').summernote({
                placeholder: "Écrire une courte description...",
                tabsize: 2,
                height: 100
            });

            $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            load_data();

            });
            
    </script>


    <!-- App js -->
    <script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    {!! Toastr::message() !!}
</body>

</html>
