@props(['route', 'icon', 'content' => __(ucfirst($route))])

<div 
    class="sub-resource {{ request()->routeIs('admin.'.$route) ? 'font-semibold text-white' : 'text-gray-400' }}">
    <x-iconed-link
        link="{{ route('admin.'.$route) }}"
        icon="{{ $icon }}"
        icon_size="md">
    {{ __(ucfirst($route)) }}
    </x-iconed-link>
</div>