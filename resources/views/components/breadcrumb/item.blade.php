@props(['href' => '#', 'active' => false])

<div class="flex items-center gap-2">
  <a href="{{ $href }}" class="text-zinc-500 text-sm font-secondary hover:text-zinc-600 transition-colors 
  {{ $active ? 'font-semibold' : '' }} after:content['>']">
    {{ $slot }}
  </a>
</div>