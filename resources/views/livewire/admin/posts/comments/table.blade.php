<section class="w-full py-4 relative" wire:loading.class="opacity-50">
    <div class="flex items-center justify-between mt-2 mb-5 sm:mb-4 ml-0.5 w-full">
        <div class="flex items-center gap-2">
            <x-fields.per-page :$perPage />

            <x-fields.search />
        </div>
    </div>

    @if($comments->count())
        <x-resource-table.index>
            <x-resource-table.head>
                <x-resource-table.header>
                    <x-fields.check-all />
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Author') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Title') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Content') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{ __('Status') }}
                </x-resource-table.header>

                <x-resource-table.header class="hidden sm:table-cell">
                    {{ __('Written at') }}
                </x-resource-table.header>

                <x-resource-table.header>
                    {{-- Dropdowns --}}
                </x-resource-table.header>
            </x-resource-table.head>

            <x-resource-table.body class="mt-4">
                @foreach ($comments as $comment)
                    <x-resource-table.row :resource="$comment" :key="$comment->getKey()">
                        <x-resource-table.cell>
                            <div class="flex items-center">
                                <x-input wire:model="selectedItemIds" value="{{ $comment->getKey() }}" type="checkbox" class="rounded border-gray-300 shadow" />
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell>
                            <div class="flex items-center gap-3">
                                <img src="{{ $comment->user->profile_photo_url }}" alt="{{ __('User profile photo') }}" class="rounded-full w-12 hidden xl:inline-block">
                                <div class="w-full xs:text-center text-sm">
                                    <p>{{ $comment->user->getName() }}</p>
                                    <p class="lowercase hidden lg:block">{{ $comment->user->getEmail() }}</p>
                                </div>
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell class="py-3">
                            <div>
                                <div class="text-base font-semibold">
                                    {{ $comment->title }}
                                </div>
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell class="py-3">
                            <div>
                                <div class="text-base font-semibold">
                                    {{ $comment->content }}
                                </div>
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell class="py-3">
                            <div class="inline-flex items-center gap-1 py-1 opacity-75">
                                {{-- <x-dynamic-component :component="$comment->getStatus()->icon()" /> --}}
                                <div>{{ $comment->status }}</div>
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell class="hidden sm:table-cell">
                            {{ $comment->created_at }}
                        </x-resource-table.cell>

                        <td>
                            <div class="flex items-center"> 
                                {{-- <x-comment.index.row-dropdown :$comment /> --}}
                            </div>
                        </td>
                    </x-resource-table.row>
                @endforeach
            </x-resource-table.body>
        </x-resource-table.index>

        <section 
            wire:loading 
            wire:target="sortBy, search, nextPage, previousPage, delete, deleteSelected, perPage" 
            class="inset-0 absolute bg-white dark:bg-asideMenu opacity-75">

            {{-- Loading canvas .. --}}

        </section>

        <section 
            wire:loading.flex 
            wire:target="sortBy, search. nextPage, previousPage, delete, deleteSelected, perPage" 
            class="inset-0 absolute flex justify-center items-center">
            <x-icon.spinner size="10" class="text-gray-500" />
        </section>
    @else
        <x-not-found-resource resource='comments' />
    @endif

    <template x-teleport="#page-section">
        @if ($comments->count())
            {{-- Pagination... --}}
            <div class="pt-4 flex justify-between items-center">
                <div class="text-gray-700 text-sm dark:text-gray-500">
                    Results: {{ \Illuminate\Support\Number::format($comments->total()) }}
                </div>

                {{ $comments->links('livewire.admin.posts.index.pagination') }}
            </div>
        @endif
    </template>
</section>