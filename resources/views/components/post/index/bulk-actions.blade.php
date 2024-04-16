<div class="flex flex-col sm:flex-row gap-2 sm:justify-end col-span-5">
    <div class="flex flex-row-reverse justify-end sm:justify-start sm:flex-row gap-2" x-show="$wire.selectedItemIds.length > 0" x-cloak>
        <div class="flex items-center gap-1 text-sm text-gray-600">
            <span x-text="$wire.selectedItemIds.length"></span>

            <span>{{ __('selected') }}</span>
        </div>

        <div class="flex items-center px-3">
            <div class="h-[75%] w-[1px] bg-gray-300"></div>
        </div>

        <form wire:submit="deleteSelected">
            <x-button component="button-danger" class="text-sm mr-2">
                <x-icon.archive-box size="7" wire:loading.remove wire:target="deleteSelected" class="pr-1"/>

                <x-icon.spinner wire:loading wire:target="deleteSelected" class="text-gray-700" />

                Delete
            </x-button>
        </form>
    </div>
</div>