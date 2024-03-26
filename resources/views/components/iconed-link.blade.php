@props(['link', 'icon' ,'wired_nav' => true, 'icon_size' => 'sm', 'classes' => null])

<a 
  href="{{ $link }}" 
  {{ $attributes->merge([
      'class' => "flex flex-row items-center $classes",
      $wired_nav ? 'wire:navigate' : null 
    ]) 
  }}
>
  <x-material-icon classes="text-{{$icon_size}} flex items-center mr">
    {{$icon}}
  </x-material-icon>

  {{ $slot }}
</a>