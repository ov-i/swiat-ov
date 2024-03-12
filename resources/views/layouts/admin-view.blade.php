<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!--  Robots -->
        <meta name="robots" content="nofollow, noindex">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,400;6..12,600&family=Open+Sans:wght@500&display=swap" rel="stylesheet">

        <!-- Favicons -->
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-primary antialiased bg-gray-100 dark:bg-gray-900 h-screen">
        <x-banner />

        <div class="min-h-screen flex flex-row">
            <!-- Page Content -->
            <main class="w-10/12 mx-auto p-4 lg:p-0 lg:py-4">
                <livewire:top-navbar />

                <section class="main-content mt-10">
                    {{ $slot }}
                </section>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
