@props(['state'])

<section 
    x-data="{ searchState: $wire.entangle('state').live }"
    class="table-actions"
    x-modeable="searchState">
    <div class="flex flex-row justify-between items-center w-full py-4 lg:py-5">
        <div class="paginate-contstrained flex flex-row space-x-2 items-center" v-show="searchState.paginate">
            <p class="text-sm text-gray-500">{{ __('Show') }}</p>
            <select name="perPage" id="perPage" x-model="searchState.perPage">
                @foreach (\App\Enums\ItemsPerPageEnum::values() as $value)
                    <option value="{{ $value }}"
                        {{ $value === \App\Enums\ItemsPerPageEnum::DEFAULT ? 'selected' : null }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="other-actions flex flex-row space-x-2 items-center">
            <x-input 
                x-ref="q" 
                id="post-search" 
                placeholder="{{ __('admin.dashboard.search') }}" 
                class="w-full"
                x-model="searchState.search" />

            <article class="filter flex items-center" x-data="{ filtersState: {
                open: false
            } }">
                <button type="button" @click="open = true">
                    <x-material-icon classes="text-[2rem]">
                        filter_alt
                    </x-material-icon>
                </button>
            </article>
        </div>
    </div>
</section> <!-- end table actions -->

<script>
    window.addEventListener('keydown', function(event) {
        if (event.key === '/') {
            event.preventDefault()
            const input = document.querySelector('#post-search')
            if (null === input) {
                return;
            }

            input.focus()
        }
    });
</script>