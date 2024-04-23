@props(['link'])

<div>
  <a href="{{ $link }}" class="button-info">
    {{ $slot }}
  </a>
</div>