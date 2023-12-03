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
            <aside class="bg-dark h-screen flex flex-col w-72 items-center">
                <!-- Top Icon -->
                <div class="p-4">
                    <x-application-mark  />
                </div>

                <!-- Navigation Items -->
                <div class="flex flex-col items-center space-y-3 text-center">
                    <section class="single-item flex flex-col">
                        <x.admin-nav-section content="Dashboards" />
                        <x-iconed-link 
                            link="{{ route('admin.dashboard') }}"
                            icon="dashboard"
                            content="Ddashboard" />
                    </section>
                    <section class="single-item flex-flex-col">
                        <x.admin-nav-section content="support" />
                        <x-iconed-link
                            link="{{ route('admin.users') }}"
                            icon="person"
                            content="Users" />
                    </section>
                    <div class="flex flex-col items-center">
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="material-icons">admin_panel_settings</span>
                        <span>Roles</span>
                    </div>
                </div>
            </aside>

            <!-- Page Content -->
            <main class="w-10/12 lg:w-8/12 2xl:w-7/12 mx-auto py-4">
                <nav class="top-navbar" aria-label="top-navbar fixed top-0">
                    <section class="top-navbar__search flex flex-rop justify-between items-center">
                        <article class="search-input flex items-center space-x-2">
                            <span class="material-symbols-outlined text-2xl">
                                manage_search
                            </span>

                            <x-input placeholder="{{ __('admin.dashboard.search') }}" class="w-full" />
                        </article>
                        <article class="profile-info flex flex-row space-x-2 items-center">
                            <div class="icons-wrapper flex flex-row space-x-2">
                                <div class="icon">
                                    <span class="material-symbols-outlined text-2xl">
                                        translate
                                    </span>
                                </div>
                                <div class="icon">
                                    <span class="material-symbols-outlined text-2xl">
                                        light_mode
                                    </span>
                                </div>
                                <div class="icon">
                                    <span class="material-symbols-outlined text-2xl">
                                        dashboard_customize
                                    </span>
                                </div>
                                <div class="icon">
                                    <span class="material-symbols-outlined text-2xl">
                                        notifications
                                    </span>
                                </div>
                            </div>

                            <div class="profile-avatar">
                                <x-user-profile />
                            </div>
                        </article>
                    </section>
                </nav>

                <section class="main-content mt-10">
                    {{ $slot }}
                </section>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
