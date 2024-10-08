<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ auth()->user()->getTheme() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel | @yield('title', config('app.name', 'Admin Panel'))</title>

    <!--  Robots -->
    <meta name="robots" content="nofollow, noindex">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,400;6..12,600&family=Open+Sans:wght@500&display=swap"
        rel="stylesheet">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://unpkg.com/@alpinejs/ui@3.13.3-beta.4/dist/cdn.min.js"></script>

    <!-- Styles -->
    @livewireStyles

</head>

<body class="font-primary antialiased bg-gray-100 dark:bg-gray-900 h-screen">
    <x-banner />

    <div 
        class="min-h-screen flex flex-row relative" 
        x-data="{ navShown: false }"
        x-cloak
        @keydown.ctrl.shift.k.window.stop="navShown = true"
        @keydown.esc.window.stop="navShown = false"
    >
        <aside 
            x-show="navShown" 
            @click.outside="navShown = false" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform opacity-0 translate-x-0"
            x-transition:enter-end="transform opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="transform opacity-300 translate-x-0"
            x-transition:leave-end="transform opacity-0"
            class="bg-asideMenu h-screen sm:flex-col w-2/3 md:w-1/3 2xl:w-80 md:flex items-center border-zinc-100 border-r-4 z-20 absolute"
        >
            <!-- Top Icon -->
            <section class="p-4 application-mark-wrapper">
                <a href="{{ route('dashboard') }}">
                    <x-application-mark class="w-3/4 ml-3" />
                </a>
            </section>

            <section class="navigation-links w-full flex flex-col pl-4">
                <section class="navigation-links__item my-2 mx-3">
                    <x-nav-section route='home' icon='home' content='Home' target='_blank' />
                </section>

                <!-- single link -->
                <article class="navigation-links__item my-2 mx-3">
                    <h2 class="text-lg resource-header text-gray-200">{{ __('Panels') }}</h2>

                    <x-nav-section route='admin.dashboard' icon='squares' content='Main' />
                </article>

                <!-- single link -->
                <article class="navigation-links__item my-2 mx-3">
                    <h2 class="resource-header text-lg text-gray-200">{{ __('Resources') }} </h2>

                    <section class="resources">
                        <!-- sub resource -->
                        <article class="sub-resources pt-4">
                            <h3 class="sub-resource-header text-md text-gray-200">{{ __('Support') }}</h3>

                            <x-nav-section route='admin.users' icon="user" content="Users" />
                            <x-nav-section route='admin.roles' icon='key' content="Roles" />
                        </article>

                        <!-- sub resource -->
                        <article class="sub-resources py-4">
                            <h3 class="sub-resource-header text-md text-gray-200">{{ __('Posts system') }}</h3>

                            <x-nav-section route='admin.comments' icon="chat-bubble-bottom-center" content="Comments" />
                            <x-nav-section route='admin.posts' icon='pencil-square' content="Posts" />
                            <x-nav-section route='admin.posts.categories' icon='rectangle-group' content="Categories" />
                            <x-nav-section route='admin.posts.tags' icon='tag' content="Tags" />
                            <x-nav-section route='admin.attachments' icon='cloud-arrow-up' content="Attachments" />
                        </article>
                    </section>
                </article>
            </section>
        </aside>

        <div x-show="navShown" class="overlay cursor-pointer hover:bg-opacity-80 active:bg-zinc-800 active:bg-opacity-60 absolute w-screen h-screen bg-zinc-700 bg-opacity-70 z-10 transition-colors ease-linear">
        </div>

        <!-- Page Content -->
        <main class="w-full lg:w-11/12 2xl:w-9/12 v-large:w-7/12 mx-auto p-4 lg:p-0 lg:py-4">
            <nav class="top-navbar" aria-label="top-navbar fixed top-0">
                <section class="top-navbar__search flex flex-row justify-between items-center">
                    <article class="flex flex-row items-center">
                        <section class="nav-opener">
                            <button type="button" class="flex items-start" @click.stop="navShown = true">
                                <x-icon.bars-3-bottom-left class="!w-7 !h-auto dark:text-white" aria-describedby="nav-opener">
                                    menu
                                </x-icon.bars-3-bottom-left>
                            </button>
                            <p class="sr-only" id="nav-opener">
                                {{ __('Navigation menu icon that opens hidden menu on mobile') }}
                            </p>
                        </section>
                        <article class="search-input flex items-center space-x-2 relative dark:text-white" >
                            <x-icon.magnifying-glass class="absolute text-2xl inset-2.5 pl-2" />

                            <x-input 
                                placeholder="{{ __('admin.dashboard.search') }}"
                                class="w-full pl-7  dark:focus:outline-none" />
                        </article>
                    </article>
                    <article class="profile-info flex flex-row space-x-2 items-center">
                        <div class="icons-wrapper flex flex-row space-x-2 items-center">
                            <x-icon.language class="dark:text-white" />
                            <livewire:theme-switcher />
                            <x-icon.squares class="dark:text-white" />
                            <x-icon.bell class="dark:text-white" />
                        </div>

                        <div class="profile-avatar">
                            <x-user-profile />
                        </div>
                    </article>
                </section>
            </nav>

            <section class="main-content mt-10 font-primary">
                {{ $slot }}
            </section>
        </main>
    </div>

    @livewireScripts

    @stack('scripts')
</body>
</html>
