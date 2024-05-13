<nav {{ $attributes->class(['w-full px-4 py-3 sticky top-0 bg-white shadow']) }} {{ $attributes }}>
    <section class="nav-wrapper flex items-center justify-between w-full">
        <section class="nav-brand flex items-center gap-2">
            <a href="{{ route('home') }}" class="flex">
                <img src="{{ asset('images/swiat-ov.svg') }}" class="block h-12 md:h-16 w-auto" alt="Swiat Ov Logo">
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
                    <x-menu>
                        <x-menu.button class="rounded hover:bg-gray-100 p-2 dark:hover:bg-transparent dark:text-white dark:hover:text-gray-300 transition-colors">
                            <div class="flex items-center gap-2">
                                <img 
                                    src="{{ auth()->user()->profile_photo_url }}" 
                                    class="h-8 w-8 rounded-full" 
                                    alt="{{ auth()->user()->name }}">
                                    
                                <span>{{ auth()->user()->getName() }}</span>

                                <template x-if="!menuOpen">
                                    <x-icon.chevron-down class="w-4 h-4" />
                                </template>

                                <x-icon.chevron-up x-show="menuOpen" class="w-4 h-4" />
                            </div>
                        </x-menu.button>

                        <x-menu.items>
                            <p class="ml-2 my-2 text-gray-500 user-select-none pointer-events-none">Dashboard</p>

                            <x-menu.close>
                                <x-menu.link :link="route('profile.show')">
                                    <x-icon.user />
                                    {{ __('Profile') }}
                                </x-menu.link>
                            </x-menu.close>

                            <x-menu.close>
                                <form method="POST" action="{{ route('logout') }}">
                                    <x-menu.item type="submit">
                                        @csrf
                                        <div class="w-full flex items-center">
                                            <x-icon.arrow-left-start-on-rectangle class="mr-2" />
                                            {{ __('Logout') }}
                                        </div>
                                    </x-menu.item>
                                </form>
                            </x-menu.close>

                            <hr class="w-full border-gray-300 my-2">
                            
                            @can('viewAdmin', auth()->user())
                                <x-menu.close>
                                    <x-menu.link :link="route('admin.dashboard')">
                                        <x-icon.lock-closed />
                                        Admin panel
                                    </x-menu.link>
                                </x-menu.close>
                            @endcan
                        </x-menu.items>
                    </x-menu>
                </li>

                @endauth
            </ul>
        </section>
    </section>
</nav>