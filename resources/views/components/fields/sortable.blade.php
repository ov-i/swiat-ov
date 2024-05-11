@props(['column', 'sortCol', 'sortAsc'])

<x-button wire:click="sortBy('{{ $column }}')" component="button" class="flex items-center gap-2 group">
    {{ $slot }}

    @if ($sortCol === $column)
        <div class="text-gray-600">
            @if ($sortAsc)
                <x-icon.arrow-long-up />
            @else
                <x-icon.arrow-long-down />
            @endif
        </div>
    @else
        <div class="text-gray-600 opacity-0 group-hover:opacity-100">
            <x-icon.arrows-up-down />
        </div>
    @endif
</x-button>