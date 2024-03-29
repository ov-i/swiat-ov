@props(['liClass' => null])

<li class="flex items-center {{ $liClass }}">
  <section {{ $attributes->merge(['class' => 'flex items-center justify-between w-full border-b-2 border-zinc-300 border-dotted font-secondary text-sm']) }}>
    {{ $slot }}
  </section>
</li>