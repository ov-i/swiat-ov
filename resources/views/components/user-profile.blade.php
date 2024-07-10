<x-menu>
    <x-menu.button class="rounded hover:bg-gray-100 p-2 dark:hover:bg-transparent dark:text-white dark:hover:text-gray-300 transition-colors">
        <div class="flex items-center gap-2">
            <img 
                src="{{ auth()->user()->profile_photo_url }}" 
                class="h-8 w-8 rounded-full" 
                alt="{{ auth()->user()->name }}">
                
            <span>{{ auth()->user()->getName() }}</span>

            <template x-if="!menuOpen">
                <x-icon.chevron-down class="w-4 h-auto" />
            </template>

            <x-icon.chevron-up x-show="menuOpen" class="w-4 h-4" />
        </div>
    </x-menu.button>

    <x-menu.items>
        <x-menu.close>
            <x-menu.link :link="route('dashboard')">
                <x-icon.squares />
                {{ __('Dashboard') }}
            </x-menu.link>
        </x-menu.close>

        <x-menu.close>
            <x-menu.link :link="route('profile.show')">
                <x-icon.cog-6-tooth />
                {{ __('Ustawienia') }}
            </x-menu.link>
        </x-menu.close>

        <x-menu.close>
            <form method="POST" action="{{ route('logout') }}">
                <x-menu.item type="submit">
                    @csrf
                    <div class="w-full flex items-center">
                        <x-icon.arrow-left-start-on-rectangle class="mr-2" />
                        {{ __('Wyloguj się') }}
                    </div>
                </x-menu.item>
            </form>
        </x-menu.close>

        @can('viewAdmin', auth()->user())
            <hr class="w-full border-gray-300 my-2">
            
            <x-menu.close>
                <x-menu.link :link="route('admin.dashboard')">
                    <x-icon.lock-closed />
                    Admin panel
                </x-menu.link>
            </x-menu.close>
        @endcan
    </x-menu.items>
</x-menu>