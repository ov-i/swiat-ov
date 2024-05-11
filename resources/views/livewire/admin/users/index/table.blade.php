<section class="w-full py-4 relative" wire:loading.class="opacity-50">
    <div class="flex items-center justify-between mt-2 mb-5 sm:mb-4 ml-0.5 w-full">
        <div class="flex items-center gap-2">
            <x-fields.per-page :$perPage />

            <x-fields.search />
        </div>

        <x-post.index.bulk-actions />
    </div>

    @if($users->count())
        <x-resource-table.index>
            <x-resource-table.head>
                <x-resource-table.header>
                    <x-fields.check-all />
                </x-resource-table.header>

                <x-resource-table.header>
                    <x-fields.sortable column="author" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('Author') }}
                    </x-fields.sortable>
                </x-resource-table.header>

                <x-resource-table.header>
                    <x-fields.sortable column="status" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('Status') }}
                    </x-fields.sortable>
                </x-resource-table.header>

                <x-resource-table.header class="hidden sm:table-cell">
                    <x-fields.sortable column="ip" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('IP') }}
                    </x-fields.sortable>
                </x-resource-table.header>

                <x-resource-table.header class="hidden sm:table-cell">
                    <x-fields.sortable column="created_at" :$sortCol :$sortAsc class="flex items-center">
                        {{ __('Created at') }}
                    </x-fields.sortable>
                </x-resource-table.header>

                <x-resource-table.header>
                    {{-- Dropdowns --}}
                </x-resource-table.header>
            </x-resource-table.head>

            <x-resource-table.body class="mt-4">
                @foreach ($users as $user)
                    <x-resource-table.row :resource="$user" :key="$user->getKey()">
                        <x-resource-table.cell>
                            <div class="flex items-center">
                                <x-input wire:model="selectedItemIds" value="{{ $user->getKey() }}" type="checkbox" class="rounded border-gray-300 shadow" />
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell>
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ __('User profile photo') }}" class="rounded-full w-12 hidden xl:inline-block">
                                <div class="w-full xs:text-center text-sm">
                                    <a 
                                        href="{{ route('admin.users.show', ['user' => $user]) }}" 
                                        class="border-b border-dashed border-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300 dark:border-zinc-500 dark:active:text-gray-200 active:text-gray-500 transition duration-100">
                                        {{ $user->getName() }}</>
                                    </a>
                                    <p class="lowercase hidden lg:block">{{ $user->getEmail() }}</p>
                                </div>
                            </div>
                        </x-resource-table.cell>

                        <x-resource-table.cell class="py-3">
                            <livewire:user-activity :$user />
                        </x-resource-table.cell>

                        <x-resource-table.cell class="py-3">
                            {{ $user->getIp() }}
                        </x-resource-table.cell>

                        <x-resource-table.cell class="hidden sm:table-cell">
                            {{ $user->created_at }}
                        </x-resource-table.cell>

                        <td>
                            <div class="flex items-center"> 
                                <x-user.index.row-dropdown :$user />
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
        <x-not-found-resource resource='users' :link="route('admin.posts.create')" />
    @endif

    <template x-teleport="#page-section">
        @if ($users->count())
            {{-- Pagination... --}}
            <div class="pt-4 flex justify-between items-center">
                <div class="text-gray-700 text-sm dark:text-gray-500">
                    Results: {{ \Illuminate\Support\Number::format($users->total()) }}
                </div>

                {{ $users->links('livewire.admin.posts.index.pagination') }}
            </div>
        @endif
    </template>
</section>