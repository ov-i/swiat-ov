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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-primary antialiased bg-gray-200 h-screen dark:bg-gray-900">
        <x-navigation.top-navbar />
        
        <div class="mt-[5.5rem]">
            @yield('content')
        </div>

        @livewireScripts
    </body>
</html>
