<nav {{ $attributes->class(['w-full px-4 py-3 fixed top-0 z-10 bg-white shadow dark:bg-asideMenu dark:text-white']) }} {{ $attributes }}>
    <section class="nav-wrapper flex items-center justify-between w-full">
        <section class="nav-brand flex items-center gap-2">
            <a href="{{ route('home') }}" class="flex">
                <x-application-logo class="h-12 md:h-16 w-auto dark:fill-white" />

                {{-- <img src="{{ asset('images/swiat-ov.svg') }}" class="block h-12 md:h-16 w-auto " alt="Swiat Ov Logo"> --}}
            </a>
            <div class="search-tool relative hidden md:block">
                <x-icon.magnifying-glass class="absolute top-1/2 left-2 transform -translate-y-1/3" />
                
                <x-input class="mt-2 pl-8" placeholder="{{ __('Czego szukasz?') }}" />
            </div>
        </section>

        <section class="nav-menu mt-2">
            <ul class="flex items-center space-x-2 lg:space-x-4 text-gray-700 dark:text-gray-300">
                <li>
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        <x-icon.home class="mr-2"/>
                        {{ __('Start') }}
                    </x-nav-link>
                </li>
                @guest
                    <li>
                        <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                            <x-icon.user class="mr-2"/>
                            {{ __('Login') }}
                        </x-nav-link>
                    </li>
                    <li class="hidden md:list-item">
                        <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                            <x-icon.plus class="mr-2"/>
                            {{ __('Stwórz konto') }}
                        </x-nav-link>
                    </li>
                @endguest
                @auth
                <li class="pb-3">
                    <x-user-profile />
                </li>
                @endauth
                <li>
                    <div class="pb-3 pr-2">
                        <livewire:theme-switcher />
                    </div>
                </li>
            </ul>
        </section>
    </section>
</nav>