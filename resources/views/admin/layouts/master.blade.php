<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@if (!empty($page_title)) {{$page_title}} @endif</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta name="csrf-token" content="{{csrf_token()}}">
    @include('admin.layouts.styles')
    @stack('styles')
    <script src="{{asset('assets/admin/js/sweetalert.js')}}"></script>
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
</head>
<body>
    <div id="app">
        @if (Request::segment(2) == 'login')
            @yield('content')
        @else
            <div class="navbar-bg"></div>
            @include('admin.layouts.navbar')
            @include('admin.layouts.sidebar')
            <div class="main-wrapper">
                @yield('content')
                @include('admin.layouts.footer')
            </div>
        @endif
    </div>
    @include('admin.layouts.scripts')
    @stack('scripts')
</body>
</html>
