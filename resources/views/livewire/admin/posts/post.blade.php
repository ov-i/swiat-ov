<section>
    <x-admin-card title="Posts">
        <x-slot name="actions">
            <x-iconed-link 
                :link="route('admin.posts.create')" 
                icon="add" 
                icon_size="text-[2rem]"
                classes="button-info-outlined p-1 flex flex-row items-center">
                {{ __('new') }}
            </x-iconed-link>
        </x-slot>
        
        <section class="component filters">
            <h3 class="text-lg font-secondary font-semibold text-gray-600">{{ __('Search Filter') }}</h3>
            <article class="filter post-table-filters w-full flex flex-row space-x-2 lg:space-x-3 py-5 lg:py-7 border-b border-gray-200">
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
            </article>
        </section>

        <section class="searchable-actions">
            <x-search-model :state="$state"/>            
        </section>

        <section class="post-table overflow-x-hidden 2xl:overflow-x-visible">
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
        </section>

        @if (blank($posts))
            <h3 class="font-primary text-lg text-gray-600 lowercase text-center my-5">
                {{ __('No posts found, ') }}
                <a href="{{ route('admin.posts.create') }}"
                    class="text-cyan-500 underlined hover:text-cyan-700 active:text-cyan-800 dark:text-white">
                    {{ __('create one here') }}
                </a>
            </h3>
        @endempty
    </x-admin-card>
    @if ($state->paginate)
        <section class="table-pagination">
            {{ $posts->links() }}
        </section>
    @endif
</section>


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
