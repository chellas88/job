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
    <script src="{{ asset('js/ajax.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    {{--    <script src="{{ asset('js/assets/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    @yield('head')
    @if (\Illuminate\Support\Facades\App::currentLocale() == 'ru')
        <link rel="alternate" hreflang="en" href="{{str_replace('ru', 'en', \Illuminate\Support\Facades\URL::current())}}"/>
        @elseif (\Illuminate\Support\Facades\App::currentLocale() == 'en')
        <link rel="alternate" hreflang="ru" href="{{str_replace('en', 'ru', \Illuminate\Support\Facades\URL::current())}}"/>
    @endif
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    {{--    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">--}}
</head>
<body>
<div id="app">
    <x-contactbar></x-contactbar>
    <x-navbar></x-navbar>

    <div class="preloader"><img src="{{ asset('images/preloader.gif') }}"></div>
    <main>
        @yield('content')
    </main>

    <x-footer></x-footer>
</div>
</body>


</html>

<script>
    window.addEventListener('load', () => {
        document.querySelector('div.preloader').style.display = 'none'
        document.querySelector('main').style.display = 'block'
    })
</script>
{{--<script>--}}
{{--    const sidebarBodyScroll = new PerfectScrollbar('body');--}}
{{--</script>--}}
