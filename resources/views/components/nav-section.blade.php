@props(['route', 'icon', 'content' => __(ucfirst($route))])

<div 
    class="sub-resource {{ request()->routeIs('admin.'.$route) ? 'font-semibold text-white' : 'text-gray-400' }}">
    
    <a href="{{ route('admin.'.$route) }}" class="flex items-center space-x-2 dark:text-white">
        <x-dynamic-component :component="'icon.'.$icon" class="icon" />
        <span>{{ $content }}</span>
    </a>
</div>