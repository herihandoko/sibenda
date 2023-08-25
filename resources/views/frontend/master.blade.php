<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        {{-- Custom Meta Tags --}}
        @yield('meta_tags')
        {{-- Title --}}
        <title>
            @yield('title_prefix', config('adminlte.title_prefix', ''))
            @yield('title', config('adminlte.title', 'Siwas'))
            @yield('title_postfix', config('adminlte.title_postfix', ''))
        </title>
        {{-- Base Stylesheets --}}
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="{{ asset('bizland/img/logo-banten.ico') }}" rel="icon">
        <link href="{{ asset('bizland/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('bizland/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('bizland/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('bizland/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('bizland/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('bizland/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('bizland/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('bizland/css/style.css') }}?v={{ date('YmdHis')}}" rel="stylesheet">
        <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
        @yield('meta_tags')
        {!! ReCaptcha::htmlScriptTagJsApi() !!}
    </head>

    <body>
        @yield('body')
        <div id="preloader"></div>

        <!-- Vendor JS Files -->
        <script src="{{ asset('bizland/vendor/purecounter/purecounter.js') }}"></script>
        <script src="{{ asset('bizland/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('bizland/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('bizland/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('bizland/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('bizland/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('bizland/vendor/waypoints/noframework.waypoints.js') }}"></script>
        <script src="{{ asset('bizland/vendor/php-email-form/validate.js') }}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('bizland/js/main.js') }}"></script>
    </body>

</html>