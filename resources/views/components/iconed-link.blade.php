@props(['link', 'content', 'icon' ,'wired_nav' => true, 'icon_size' => 'sm'])

<a 
  href="{{ $link }}" 
  class="flex flex-row items-center"
  {{ $wired_nav ? 'wire:navigate' : null }}
>
  <span class="material-symbols-outlined text-{{ $icon_size }} mr-2">
    {{ $icon }}
  </span>

  {{ __($content) }}
</a>