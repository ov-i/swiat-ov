@props(['title', 'content'])

<x-dropdown align="left">
  <x-slot name="trigger">
      <button class="flex text-sm border-2 w-full px-3 py-2 rounded focus:outline-none focus:border-gray-330">
          <p class="flex flex-row items-center justify-between w-full">
              {{ __($title) }}
              <span class="material-symbols-outlined">
                  expand_more
              </span>
          </p>
      </button>
  </x-slot>

  <x-slot name="content">
      {{ $content }}
  </x-slot>
</x-dropdown>