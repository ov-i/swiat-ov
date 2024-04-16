<section class="w-full py-4 relative" wire:loading.class="opacity-50">
    <div class="flex items-center justify-between mb-3 ml-1 w-full">
        <x-post.index.search :$posts />

        <x-post.index.bulk-actions />
    </div>

    @if($posts->count())
        <x-resource-table.index>
            <x-resource-table.head>
                <x-resource-table.header>
                    <x-post.index.check-all />
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Author') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Title') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Status') }}
                </x-resource-table.header>

                <x-resource-table.header class="hidden sm:table-cell">
                    {{ __('Type') }}
                </x-resource-table.header>

                <x-resource-table.header class="hidden sm:table-cell">
                    {{ __('Category') }}
                </x-resource-table.header>

                <x-resource-table.header class="hidden sm:table-cell">
                    {{ __('Written at') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{-- Dropdowns --}}
                </x-resource-table.header>
            </x-resource-table.head>

            <x-resource-table.body>
                @foreach ($posts as $post)
                    <x-resource-table.row :resource="$post" :key="$post->getKey()">
                        <td class="whitespace-nowrap p-3 text-sm">
                            <div class="flex items-center">
                                <input wire:model="selectedItemIds" value="{{ $post->getKey() }}" type="checkbox" class="rounded border-gray-300 shadow">
                            </div>
                        </td>

                        <td class="capitalize py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $post->user->profile_photo_url }}" alt="{{ __('User profile photo') }}" class="rounded-full w-12 hidden xl:inline-block">
                                <div class="w-full xs:text-center text-sm">
                                    <p>{{ $post->user->getName() }}</p>
                                    <p class="lowercase hidden lg:block">{{ $post->user->getEmail() }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm">
                            <div>
                                <div class="text-base font-semibold">
                                    @if ($post->isClosed() || !auth()->user()->can('view', $post))
                                        {{ $post->getTitle() }}
                                    @else
                                        <a 
                                            href="{{ route('admin.posts.show', ['post' => $post]) }}"
                                            class="hover:text-gray-700 dark:hover:text-zinc-300 active:text-gray-800 transition duration-100">
                                            {{ $post->getTitle() }}
                                        </a>
                                    @endif
                                    <div class="font-normal text-gray-500">{{ $post->getSlug() }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm">
                            <div class="inline-flex items-center gap-1 py-1 {{ $post->getStatus()->color() }} opacity-75">
                                <x-dynamic-component :component="$post->getStatus()->icon()" />
                                <div>{{ $post->getStatus()->label() }}</div>
                            </div>
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm hidden sm:table-cell">
                            <div class="inline-flex items-center gap-1 py-1">
                                <x-dynamic-component :component="$post->getType()->icon()" />
                                <div>{{ $post->getType()->label() }}</div>
                            </div>
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm hidden sm:table-cell">
                            {{ $post->category->getName() }}
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm hidden sm:table-cell">
                            {{ $post->created_at }}
                        </td>

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
            wire:target="search, nextPage, previousPage, delete, deleteSelected" 
            class="inset-0 absolute bg-white opacity-50">
            {{-- Loading canvas .. --}}
        </section>

        <section 
            wire:loading.flex 
            wire:target="search. nextPage, previousPage, delete, deleteSelected" 
            class="inset-0 absolute flex justify-center items-center">
            <x-icon.spinner size="10" class="text-gray-500" />
        </section>
    @else
        <h3 class="font-primary text-lg text-gray-600 lowercase text-center my-5">
            {{ __('No posts found, ') }}
            
            <a href="{{ route('admin.posts.create') }}"
                class="text-cyan-500 underlined hover:text-cyan-700 active:text-cyan-800 dark:text-white">
                {{ __('create one here') }}
            </a>
        </h3>
    @endif

    <template x-teleport="#page-section">
        <section class="links mt-2 flex items-center w-full justify-between">
            <div x-show="$wire.posts.length">
                {{ __('Total records:') }} {{ Illuminate\Support\Number::format($posts->total()) }}
                {{ $posts->links('livewire.admin.posts.index.pagination') }}
            </div>
        </section>
    </template>
</section>