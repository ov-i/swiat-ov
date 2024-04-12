@props(['to', 'innerClasses' => null])

<a href="{{ $to }}" {{ $attributes->merge(['class' => 'flex items-center text-lg mb-2 py-2']) }}>
  <x-icon.arrow-uturn-left />
  
  <p class="ml-2 hover:text-zinc-600 active:text-zinc-800 dark:text-white dark:hover:text-zinc-400 dark:active:text-zinc-300 transition-colors duration-150 {{ $innerClasses }}">
    {{ $slot }}
  </p>
</a>