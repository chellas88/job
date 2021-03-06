<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
{{--    <script src="{{ asset('js/ajax.js') }}" defer></script>--}}
    <script src="{{ asset('js/admin.js') }}" defer></script>
    {{--    <script src="{{ asset('js/assets/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    @yield('head')

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    {{--    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">--}}
</head>
<body>
<div id="app">
    <x-admin.sidebar></x-admin.sidebar>


    <main class="main">
        @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
        @if(session('alert'))
            <div class="alert alert-danger mb-2">
                {{session('alert')}}
            </div>
        @endif
        @yield('content')
    </main>


</div>
</body>


</html>


