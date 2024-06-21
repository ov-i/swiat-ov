<section x-cloak>
    @auth
        @if(!$user->isPostAuthor($post))
            <form wire:submit.throttle.1000ms="toggleBookmark">
                <x-button component="button dark:text-white flex items-center gap-2 text-sm">
                    <x-icon.bookmark x-bind:class="[
                        'w-5 h-5',
                        $wire.alreadyFollowed ? 'fill-cyan-600 stroke-cyan-600' : ''
                    ]" />
        
                    <span x-show="!$wire.alreadyFollowed">{{ __('Zapisz') }}</span>
                    <span x-show="$wire.alreadyFollowed">{{ __('Usuń') }}</span>

                    <x-icon.spinner class="animate" wire:loading wire:loading.target="toggleBookmark" />
                </x-button>
            </form>
        @endif
    @endauth
</section>