<section class="w-full py-4 relative" wire:loading.class="opacity-50">
    <div class="flex items-center justify-between mt-2 mb-5 sm:mb-4 ml-0.5 w-full">
        <div class="flex items-center gap-2">
            <x-fields.per-page :$perPage />

            <x-post.index.search :$posts />
        </div>

        <x-post.index.bulk-actions />
    </div>

    @if($posts->count())
        <x-resource-table.index>
            <x-resource-table.head>
                <x-resource-table.header>
                    <x-post.index.check-all />
                </x-resource-table.header>

                <x-resource-table.header>
                    <x-post.index.sortable column="author" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('Author') }}
                    </x-post.index.sortable>
                </x-resource-table.header>

                <x-resource-table.header>
                    <x-post.index.sortable column="title" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('Title') }}
                    </x-post.index.sortable>
                </x-resource-table.header>

                <x-resource-table.header>
                    <x-post.index.sortable column="status" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('Status') }}
                    </x-post.index.sortable>
                </x-resource-table.header>

                <x-resource-table.header class="hidden sm:table-cell">
                    <x-post.index.sortable column="type" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('Type') }}
                    </x-post.index.sortable>
                </x-resource-table.header>

                <x-resource-table.header class="hidden sm:table-cell">
                    <x-post.index.sortable column="category" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('Category') }}
                    </x-post.index.sortable>
                </x-resource-table.header>

                <x-resource-table.header class="hidden sm:table-cell">
                    <x-post.index.sortable column="written_at" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('Written at') }}
                    </x-post.index.sortable>
                </x-resource-table.header>

                <x-resource-table.header>
                    {{-- Dropdowns --}}
                </x-resource-table.header>
            </x-resource-table.head>

            <x-resource-table.body class="mt-4">
                @foreach ($posts as $post)
                    <x-resource-table.row :resource="$post" :key="$post->getKey()">
                        <x-resource-table.cell>
                            <div class="flex items-center">
                                <x-input wire:model="selectedItemIds" value="{{ $post->getKey() }}" type="checkbox" class="rounded border-gray-300 shadow" />
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell>
                            <div class="flex items-center gap-3">
                                <img src="{{ $post->user->profile_photo_url }}" alt="{{ __('User profile photo') }}" class="rounded-full w-12 hidden xl:inline-block">
                                <div class="w-full xs:text-center text-sm">
                                    <p>{{ $post->user->getName() }}</p>
                                    <p class="lowercase hidden lg:block">{{ $post->user->getEmail() }}</p>
                                </div>
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell class="py-3">
                            <div>
                                <div class="text-base font-semibold">
                                    @if ($post->isClosed() || !auth()->user()->can('view', $post))
                                        {{ $post->getTitle() }}
                                    @else
                                        <a 
                                            href="{{ route('admin.posts.show', ['post' => $post]) }}"
                                            class=" border-b border-dashed border-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300 dark:border-zinc-500 dark:active:text-gray-200 active:text-gray-500 transition duration-100">
                                            {{ str($post->getTitle())->words(4) }}
                                        </a>
                                    @endif
                                    <div class="font-normal text-gray-500 pt-1">{{ $post->getSlug() }}</div>
                                </div>
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell class="py-3">
                            <div class="inline-flex items-center gap-1 py-1 {{ $post->getStatus()->color() }} opacity-75">
                                <x-dynamic-component :component="$post->getStatus()->icon()" />
                                <div>{{ $post->getStatus()->label() }}</div>
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell class="hidden sm:table-cell">
                            <div class="inline-flex items-center gap-1 py-1">
                                <x-dynamic-component :component="$post->getType()->icon()" />
                                <div>{{ $post->getType()->label() }}</div>
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell class="hidden sm:table-cell">
                            {{ $post->category->getName() }}
                        </x-resource-table.cell>

                        <x-resource-table.cell class="hidden sm:table-cell">
                            {{ $post->created_at }}
                        </x-resource-table.cell>

                        <td>
                            <div class="flex items-center"> 
                                <x-post.index.row-dropdown :$post />
                            </div>
                        </td>
                    </x-resource-table.row>
                @endforeach
            </x-resource-table.body>
        </x-resource-table.index>

        <section 
            wire:loading 
            wire:target="sortBy, search, nextPage, previousPage, delete, deleteSelected" 
            class="inset-0 absolute bg-white dark:bg-asideMenu opacity-75">

            {{-- Loading canvas .. --}}

        </section>

        <section 
            wire:loading.flex 
            wire:target="sortBy, search. nextPage, previousPage, delete, deleteSelected" 
            class="inset-0 absolute flex justify-center items-center">
            <x-icon.spinner size="10" class="text-gray-500" />
        </section>
    @else
        <x-not-found-resource resource='posts' :link="route('admin.posts.create')" />
    @endif

    <template x-teleport="#page-section">
        @if ($posts->count())
            {{-- Pagination... --}}
            <div class="pt-4 flex justify-between items-center">
                <div class="text-gray-700 text-sm dark:text-gray-500">
                    Results: {{ \Illuminate\Support\Number::format($posts->total()) }}
                </div>

                {{ $posts->links('livewire.admin.posts.index.pagination') }}
            </div>
        @endif
    </template>
</section>