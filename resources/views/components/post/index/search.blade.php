@props(['posts'])

<div {{ $attributes->class(['relative text-sm text-gray-500 w-full sm:w-auto']) }} x-data="{ focused: false }">
    <div class="absolute left-0 top-0 bottom-0 flex items-center pl-3 pointer-events-none">
        <x-icon.magnifying-glass />
    </div>

    <x-input
        x-on:click.outside="focused = false"
        x-on:keyup.slash.window.prevent="$refs.search.focus(); focused = true"
        x-on:keyup.escape.window.prevent="$refs.search.blur(); focused = false"
        x-ref="search"
        wire:model.live="search"
        placeholder="{{ __('What are you searching for?') }}" 
        id="post-search"
        class="pl-10 lg:!w-72 w-full py-3 sm:py-2" />

    <div class="absolute right-0 top-0 bottom-0 flex items-center pr-3" x-show="focused">
        <x-icon.x-mark />
    </div>
</div>