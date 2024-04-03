@props(['link', 'icon' ,'wired_nav' => true, 'icon_size' => 'md'])

<a 
  href="{{ $link }}" 
  {{ $attributes->merge(['class' => "flex flex-row items-center"]) }} 
  {{ $wired_nav ? 'wire:navigate' : null}}
>
  <x-material-icon class="text-{{$icon_size}} flex items-center">
    {{$icon}}
  </x-material-icon>

  {{ $slot }}
</a>