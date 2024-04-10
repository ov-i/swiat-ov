@props(['link', 'icon' => 'add', 'icon_size' => 'text-[2rem]'])

<x-iconed-link :$link :$icon :$icon_size {{ $attributes }}>
    {{ $slot }}
</x-iconed-link>