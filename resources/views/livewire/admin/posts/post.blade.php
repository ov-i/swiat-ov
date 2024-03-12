<section>
    <section class="heading-wrapper flex items-center justify-between">
        <h1 class="text-2xl font-primary text-gray-600">{{ __('Posts') }}</h1>

        <div class="flex flex-row items-center">
            <a href="{{ route('admin.posts.create') }}" class="button-info-outlined p-1 flex flex-row items-center">
                <span class="material-symbols-outlined">
                    add
                </span>
                new
            </a>
        </div>
    </section>

    <h3 class="text-lg font-secondary font-semibold text-gray-600">{{ __('Search Filter') }}</h3>
    <section
        class="post-table-filters w-full flex flex-row space-x-2 lg:space-x-3 py-5 lg:py-7 border-b border-gray-200">
        <div class="table-filter w-full">
            <x-expandable-button title="{{ __('Select type') }}">
                <x-slot name="content">
                    <ul>
                        <ul>li</ul>
                        <ul>li</ul>
                        <ul>li</ul>
                    </ul>
                </x-slot>
            </x-expandable-button>
        </div>
        <div class="table-filter w-full">
            <x-expandable-button title="{{ __('Select status') }}">
                <x-slot name="content">
                    <ul>
                        <ul>li</ul>
                        <ul>li</ul>
                        <ul>li</ul>
                    </ul>
                </x-slot>
            </x-expandable-button>
        </div>
        <div class="table-filter w-full">
            <x-expandable-button title="{{ __('Select category') }}">
                <x-slot name="content">
                    <ul>
                        <ul>li</ul>
                        <ul>li</ul>
                        <ul>li</ul>
                    </ul>
                </x-slot>
            </x-expandable-button>
        </div>
    </section>

    <!-- Table actions -->
    <section class="table-actions">
        <div class="flex flex-row justify-between items-center w-full py-4 lg:py-5">
            <div class="paginate-contstrained flex flex-row space-x-2 items-center">
                <p class="text-sm text-gray-500">{{ __('Show') }}</p>
                <select name="perPage" id="perPage" wire:model.live="perPage">
                    @foreach (\App\Enums\ItemsPerPageEnum::values() as $value)
                        <option value="{{ $value }}"
                            {{ $value === \App\Enums\ItemsPerPageEnum::DEFAULT ? 'selected' : null }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="other-actions">
                <x-input id="post-search" placeholder="{{ __('admin.dashboard.search') }}" class="w-full"
                    wire:model.live.250ms="search" />
            </div>
        </div>
    </section> <!-- end table actions -->

    <section class="post-table">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <label for="checkbox-all-search" class="sr-only">
                                checkbox
                            </label>
                            <x-checkbox id="checkbox-all-search" />
                        </div>
                    </th>

                    <th scope="col" class="px-6 py-3 text-md">#</th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Title') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Author') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Category') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Status') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Type') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Action') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr class="bg-white border-b last:border-none dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        wire:key="{{ $post->getKey() }}">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                <x-checkbox id="checkbox-table-search-1" />
                            </div>
                        </td>
                        <td class="w-4 p-4">{{ $post->getKey() }}</td>
                        <td scope="row" class="text-gray-600 whitespace-nowrap dark:text-white">
                            <div class="ps-3">
                                <div class="text-base font-semibold">
                                    <a href="{{ route('admin.posts.edit', ['post' => $post]) }}"
                                        class="hover:text-gray-700 active:text-gray-800 transition duration-100">
                                        {{ $post->getTitle() }}
                                    </a>
                                </div>
                                <div class="font-normal text-gray-500">{{ $post->getSlug() }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $post->user()->first()->getName() }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $post->category()->first()->getName() }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $post->getStatus() }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $post->getType() }}
                        </td>
                        <td class="px-6 py-4">
                            <x-dropdown align="left">
                                <x-slot name="trigger">
                                    <span class="material-symbols-outlined text-xl cursor-pointer">
                                        more_vert
                                    </span>
                                </x-slot>
                                <x-slot name="content">
                                    <!-- Actions list -->
                                    <ul class="space-y-2 text-md">
                                        <!-- single list item -->
                                        <li>
                                            <x-iconed-link content="Edit user" icon="edit"
                                                link="{{ route('admin.posts.edit', ['post' => $post]) }}" />
                                        </li> <!-- end item -->

                                        <!-- single list item -->
                                        <li>
                                            <div class="flex cursor-pointer hover:text-gray-600 flex-row items-center text-md"
                                                wire:click="delete({{ $post->getKey() }})"
                                                wire:confirm="Soft delete this post?">
                                                <span class="material-symbols-outlined text-sm mr-2">
                                                    delete
                                                </span>

                                                {{ __('Delete post') }}
                                            </div>
                                        </li> <!-- end item -->
                                    </ul> <!-- end actions list -->
                                </x-slot>
                            </x-dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if (blank($posts))
            <h3 class="font-primary text-lg text-gray-600 lowercase text-center my-5">
                {{ __('No posts found, ') }}
                <a href="{{ route('admin.posts.create') }}"
                    class="text-cyan-500 underlined hover:text-cyan-700 active:text-cyan-800 dark:text-white">
                    {{ __('create one here') }}
                </a>
            </h3>
        @endempty
</section>

<section class="table-pagination">
    {{ $posts->links() }}
</section>

<script>
    window.addEventListener('keydown', function(event) {
        if (event.key === '/') {
            const input = document.querySelector('#post-search')
            if (null === input) {
                return;
            }

            input.focus()
        }
    });
</script>
</section>
