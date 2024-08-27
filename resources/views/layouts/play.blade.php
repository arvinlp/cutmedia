<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_url" content="{{ url(('/')) }}">
    @yield('seo')
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @yield('head')
</head>

<body>
    <div id="app">
        <nav id="AlpNavbar" class="navbar navbar-expand-md navbar-light alp-main-navbar">
            @include('include.navbar')
        </nav>
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/fontawesome/all.min.js') }}" type="text/javascript"></script>
    @yield('footer')
</body>

</html>