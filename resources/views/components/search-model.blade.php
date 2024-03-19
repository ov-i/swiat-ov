@props(['state'])

<section 
    x-data="{ state: $wire.entangle('state').live }"
    class="table-actions"
    x-modeable="state">
    <div class="flex flex-row justify-between items-center w-full py-4 lg:py-5">
        <div class="paginate-contstrained flex flex-row space-x-2 items-center" v-show="state.paginate">
            <p class="text-sm text-gray-500">{{ __('Show') }}</p>
            <select name="perPage" id="perPage" x-model="state.perPage">
                @foreach (\App\Enums\ItemsPerPageEnum::values() as $value)
                    <option value="{{ $value }}"
                        {{ $value === \App\Enums\ItemsPerPageEnum::DEFAULT ? 'selected' : null }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="other-actions">
            <x-input 
                x-ref="q" 
                id="post-search" 
                placeholder="{{ __('admin.dashboard.search') }}" 
                class="w-full"
                x-model="state.search" />
        </div>
    </div>
</section> <!-- end table actions -->