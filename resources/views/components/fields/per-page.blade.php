@props(['perPage'])

<div>
    <x-popover>
        <x-popover.button class="flex items-center justify-between gap-2 rounded-lg border pl-3 pr-2 py-2 sm:py-2.5 text-gray-600 dark:text-gray-400 my-1 sm:my-0">
            <div>
                Slice {{ $perPage->slice->label() }}
            </div>

            <x-icon.chevron-down />
        </x-popover.button>

        <x-popover.panel class="border border-gray-100 shadow-xl z-10 w-full sm:w-auto" posititon="bottom-end">
            <div class="flex flex-col divide-y divide-gray-100 min-w-64">
                @foreach (App\Enums\ItemsPerPage::cases() as $slice)
                  <x-popover.close>
                      <x-button wire:click="$set('perPage.slice', '{{ $slice }}')" component="button" class="w-full flex items-center justify-between text-gray-800 px-3 py-2 gap-2 cursor-pointer hover:bg-gray-100">
                          <div class="text-sm">{{ $slice->label() }}</div>
                          @if ($slice === $perPage->slice)
                            <x-icon.check />
                          @endif
                      </x-button>
                  </x-popover.close>
                @endforeach
            </div>
        </x-popover.panel>
    </x-popover>
</div>