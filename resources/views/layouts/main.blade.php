<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Świat OV'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,400;6..12,600&family=Open+Sans:wght@500&display=swap"
            rel="stylesheet">

        {{-- Favicons --}}
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
        <link rel="manifest" href="{{ asset('build/manifest.json') }}">

        @yield('meta')  

        <script defer src="https://unpkg.com/@alpinejs/ui@3.13.3-beta.4/dist/cdn.min.js"></script>

        @if (\App\Lib\SwiatOv\Features::hasAnalytics())
            <x-config.clarity-config />
            <x-config.ga-config />
        @endif

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-primary antialiased bg-gray-200 max-h-screen dark:bg-gray-900">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NC3P4QHP"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <x-navigation.top-navbar />
        
        <div>
            <section class="mt-[6rem] md:mt-[7rem]">
                @yield('content')
            </section>
        </div>

        @livewireScripts
    </body>
</html>

<script>
    function isAuthenticated() {
        return @js(auth()->check());
    }

    function addDataThemeAttr() {
        const htmlTag = document.querySelector('html');
        
        htmlTag.setAttribute('data-theme', getTheme());
    }

    function getTheme() {
        let userTheme = null;

        if (localStorage.getItem('theme') !== null) {
            userTheme = localStorage.getItem('theme');
        } else if (isAuthenticated()) {
            userTheme = @js(auth()->user()?->getTheme());
        } else {
            userTheme = 'light';
        }

        return userTheme;
    }

    addDataThemeAttr(isAuthenticated());
</script>