<section class="post-table overflow-x-auto py-4 relative" wire:loading.class="opacity-50">
    @if($posts->count())
        <x-resource-table.index>
            <x-resource-table.head>
                <x-resource-table.header>
                    {{ __('Author') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Title') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Status') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Type') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Category') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Written at') }}
                </x-resource-table.header>

                <x-resource-table.header>
                </x-resource-table.header>
            </x-resource-table.head>

            <x-resource-table.body>
                @foreach ($posts as $post)
                    <x-resource-table.row :resource="$post" :key="$post->getKey()">
                        <td class="px-6 py-4 capitalize">
                            {{ $post->user->getName() }}
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm">
                            <div>
                                <div class="text-base font-semibold">
                                    <a href="{{ route('admin.posts.show', ['post' => $post]) }}"
                                        class="hover:text-gray-700 dark:hover:text-zinc-300 active:text-gray-800 transition duration-100">
                                        {{ $post->getTitle() }}
                                    </a>
                                </div>
                                <div class="font-normal text-gray-500">{{ $post->getSlug() }}</div>
                            </div>
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm">
                            <div class="inline-flex items-center gap-1 py-1 text-{{ $post->getStatus()->color() }} opacity-75">
                                <x-dynamic-component :component="$post->getStatus()->icon()" />
                                <div>{{ $post->getStatus()->label() }}</div>
                            </div>
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm">
                            <div class="inline-flex items-center gap-1 py-1">
                                <x-dynamic-component :component="$post->getType()->icon()" />
                                <div>{{ $post->getType()->label() }}</div>
                            </div>
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm">
                            {{ $post->category->getName() }}
                        </td>

                        <td class="whitespace-nowrap p-3 text-sm">
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

        <section wire:loading wire:target="nextPage, previousPage, delete" class="inset-0 absolute bg-white opacity-50">
            
        </section>

        <section wire:loading.flex wire:target="nextPage, previousPage" class="inset-0 absolute flex justify-center items-center">
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
            {{ __('Records:') }} {{ Illuminate\Support\Number::format($posts->total()) }}
            {{ $posts->links('livewire.admin.posts.index.pagination') }}
        </section>
    </template>
</section>