@props(['route', 'icon', 'content', 'target' => '_self'])

<div 
    class="sub-resource {{ request()->routeIs($route) ? 'font-semibold text-white' : 'text-gray-400' }}">
    
    <a href="{{ route($route) }}" class="flex items-center space-x-2 dark:text-white" {{ $attributes->merge(['target' => $target]) }}>
        <x-dynamic-component :component="'icon.'.$icon" class="icon" />
        <span>{{ $content }}</span>
    </a>
</div>