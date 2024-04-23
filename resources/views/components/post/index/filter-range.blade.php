@props(['filters'])

<div class="w-full sm:w-auto">
    <x-popover>
        <x-popover.button class="flex items-center justify-between gap-2 rounded-lg border pl-3 pr-2 py-2 sm:py-1 text-gray-600 dark:text-gray-400 w-full my-1 sm:my-0">
            <div class="xs:w-full">
                {{ $filters->rangeFilter->range->label() }}
            </div>

            <x-icon.chevron-down />
        </x-popover.button>

        <x-popover.panel class="border border-gray-100 shadow-xl z-10 w-full sm:w-auto" position="bottom-end">
            <div class="flex flex-col divide-y divide-gray-100 min-w-64">
                @foreach (App\Livewire\Enums\Range::cases() as $range)
                  <x-popover.close>
                      <x-button wire:click="$set('filters.rangeFilter.range', '{{ $range }}')" component="button" class="w-full flex items-center justify-between text-gray-800 px-3 py-2 gap-2 cursor-pointer hover:bg-gray-100">
                          <div class="text-sm">{{ $range->label() }}</div>
                          @if ($range === $filters->rangeFilter->range)
                            <x-icon.check />
                          @endif
                      </x-button>
                  </x-popover.close>
                @endforeach
            </div>
        </x-popover.panel>
    </x-popover>
</div>