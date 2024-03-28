<section>
    <x-back-button :to="route('admin.dashboard')">
        {{ __('Back to dashboard') }}
    </x-back-button>

    <x-admin-card title="Posts">
        <x-slot name="actions">
            <x-iconed-link 
                :link="route('admin.posts.create')" 
                icon="add" 
                icon_size="text-[2rem]"
                classes="button-info">
                {{ __('new') }}
            </x-iconed-link>
        </x-slot>
        
        <section class="py-4 border-b border-gray-200 dark:border-gray-600">
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

                @foreach ($resource as $post)
                    <tr class="resource-tr" wire:key="{{ $post->getKey() }}">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <x-label for="checkbox-table-search-1" class="sr-only" value="Checkbox" />
                                <x-checkbox id="checkbox-table-search-1" />
                            </div>
                        </td>
                        <td class="w-4 p-4">{{ $post->getKey() }}</td>
                        <td scope="row" class="text-gray-600 whitespace-nowrap dark:text-white">
                            <div class="ps-3">
                                <div class="text-base font-semibold">
                                    <a href="{{ route('admin.posts.edit', ['post' => $post]) }}"
                                        class="hover:text-gray-700 dark:hover:text-zinc-300 active:text-gray-800 transition duration-100">
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
                            <div class="flex items-center text-center">
                                <section class="mr-2">
                                    <x-button
                                    type="button"
                                    component="button-danger"
                                    class="flex items-center"
                                    wire:click="delete({{ $post->getKey() }})"
                                    wire:confirm="Soft delete this post?">
                                    <x-material-icon class="mr-0">
                                        delete
                                    </x-material-icon>
                                </x-button>
                                </section>
                                <section>
                                    <a href="{{ route('admin.posts.edit', ['post' => $post]) }}" class="flex items-center button-info">
                                        <x-material-icon 
                                            link="{{ route('admin.posts.edit', ['post' => $post]) }}"
                                            class="mr-0">
                                            edit
                                        </x-material-icon>
                                    </a>
                                </section>                                 
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-resource-table>
        </section>

        @if (blank($resource))
            <h3 class="font-primary text-lg text-gray-600 lowercase text-center my-5">
                {{ __('No posts found, ') }}
                <a href="{{ route('admin.posts.create') }}"
                    class="text-cyan-500 underlined hover:text-cyan-700 active:text-cyan-800 dark:text-white">
                    {{ __('create one here') }}
                </a>
            </h3>
        @endempty
    </x-admin-card>

    <x-pagination-links :$resource />
</section>

