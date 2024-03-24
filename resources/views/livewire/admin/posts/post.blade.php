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
        
        <section class="py-4 border-b border-gray-200">
            <h3 class="text-lg font-secondary font-semibold text-gray-600 dark:text-zinc-300">
                {{ __('Search & Filters') }}
            </h3>
        </section>

        <section class="searchable-actions">
            <x-search-model :state="$state"/>            
        </section>

        <section class="post-table overflow-x-hidden 2xl:overflow-x-visible">
            <x-resource-table>
                <x-slot name="tableHead">
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
                </x-slot>

                @foreach ($posts as $post)
                    <tr 
                        class="bg-white border-b last:border-none dark:bg-white dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-white"
                        wire:key="{{ $post->getKey() }}"
                    >
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
                                    <button type="button">
                                        <x-material-icon classes="text-xl cursor-pointer">
                                            more_vert
                                        </x-material-icon>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <!-- Actions list -->
                                    <ul class="space-y-2 text-md">
                                        <!-- single list item -->
                                        <li>
                                            <x-iconed-link 
                                                icon="edit"
                                                class="mr-1"
                                                link="{{ route('admin.posts.edit', ['post' => $post]) }}">
                                                {{ __('Edit post') }}
                                            </x-iconed-link>
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
            </x-resource-table>
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

    <x-pagination-links :resource="$posts" :state="$state" />
</section>

