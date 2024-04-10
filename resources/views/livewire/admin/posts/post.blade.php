<section>
    <x-back-button :to="route('admin.dashboard')">
        {{ __('Back to dashboard') }}
    </x-back-button>

    <x-admin-card title="Posts">
        <x-slot name="actions">
            @if ($this->getUser()->can('write-post'))
                <x-admin-card.actions :link="route('admin.posts.create')" class="button-info">
                    {{ __('new') }}
                </x-admin-card.actions>
            @endif
        </x-slot>
        
        <section class="py-4 border-b border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-secondary font-semibold text-gray-600 dark:text-zinc-300">
                {{ __('Search & Filters') }}
            </h3>
        </section>

        <section class="searchable-actions">
            <x-search-model :state="$state"/>
        </section>

        <section class="post-table overflow-x-hidden 2xl:overflow-x-visible" wire:loading.class="opacity-50">
            <x-resource-table.index>
                <x-resource-table.head>
                    <x-resource-table.header>
                        #
                    </x-resource-table.header>

                    <x-resource-table.header>
                        {{ __('Title') }}
                    </x-resource-table.header>

                    <x-resource-table.header>
                        {{ __('Author') }}
                    </x-resource-table.header>

                    <x-resource-table.header>
                        {{ __('Category') }}
                    </x-resource-table.header>
                    
                    <x-resource-table.header>
                        {{ __('Status') }}
                    </x-resource-table.header>

                    <x-resource-table.header>
                        {{ __('Type') }}
                    </x-resource-table.header>

                    <x-resource-table.header>
                        {{ __('Action') }}
                    </x-resource-table.header>
                </x-resource-table.head>

                <x-resource-table.body>
                    @foreach ($resource as $post)
                        <x-resource-table.row :resource="$post" :key="$post->getKey()">
                            <td class="w-4 mx-auto p-4">{{ $post->getKey() }}</td>

                            <td scope="row" class="text-gray-600 whitespace-nowrap dark:text-white">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">
                                        <a href="{{ route('admin.posts.show', ['post' => $post]) }}"
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
                                <div class="flex items-center text-center mx-auto">
                                    @if ($this->getUser()->can('view-post'))
                                        <section>
                                            <x-admin-card.actions 
                                                class="button"
                                                icon="visibility"
                                                :link="route('admin.posts.show', ['post' => $post])" />
                                        </section>
                                    @endif

                                    @if ($this->getUser()->can('can-edit-post', [$post]))
                                        <section>
                                            <x-admin-card.actions
                                                :link="route('admin.posts.edit', ['post' => $post])"
                                                icon="edit"
                                                class="button" />
                                        </section>
                                    @endif

                                    @if ($this->getUser()->can('delete-post', [$post]))
                                        <section class="mr-2">
                                            <x-button
                                            type="button"
                                            component="button"
                                            class="flex items-center"
                                            wire:click="delete({{ $post->getKey() }})"
                                            wire:confirm="Soft delete this post?">
                                                <x-material-icon class="mr-0 text-md">
                                                    delete
                                                </x-material-icon>
                                            </x-button>
                                        </section>                             
                                    @endif
                                </div>
                            </td>
                        </x-resource-table.row>
                    @endforeach
                </x-resource-table.body>
            </x-resource-table.index>
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

