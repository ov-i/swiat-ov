<div class="flex flex-row justify-between items-center w-full py-4 lg:py-5">
    <div class="paginate-contstrained flex flex-row space-x-2 items-center">
        <p class="text-sm text-gray-500">{{ __('Show') }}</p>
        <x-expandable-button title="Choose">
            <x-slot name="content">
                <ul>
                    <li>10</li>
                    <li>20</li>
                    <li>30</li>
                </ul>
            </x-slot>
        </x-expandable-button>
    </div>
    <div class="other-actions">
        <x-input placeholder="{{ __('admin.dashboard.search') }}" class="w-full" />
    </div>
</div>