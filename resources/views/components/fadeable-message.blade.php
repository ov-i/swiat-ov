@props(['property', 'message', 'timeout' => 3000, 'error' => false])

<section
  {{ $attributes->class(['flex items-center justify-between']) }}
  x-transition.out.opacity.duration.2000ms
  x-effect="if({{ $property }}) setTimeout(() => {{ $property }} = false, {{ $timeout }})"
  x-show="{{ $property }}"
>
  <div></div>
  <article 
    @class([
      "flex items-center gap-2",
       $error ? 'text-red-500' : 'text-green-500'
    ])>
    <x-dynamic-component :component="$error ? 'icon.check' : 'icon.exclamation-circle'" />

    <p class="text-lg font-semibold">{{ $message }}</p>
  </article>
</section>