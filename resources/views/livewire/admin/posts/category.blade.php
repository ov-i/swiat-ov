@php
    $loggedInUser = auth()->user();
@endphp

<section>
    <x-back-button :to="route('admin.dashboard')">
        {{ __('Back to dashboard') }}
    </x-back-button>

    <x-admin-card title="Categories">
        <x-slot name="actions">
            @if ($loggedInUser->can('write-category'))
                <section>
                    <x-button type="button" class="text-sm md:text-md lg:text-base" wire:click="openModal()">
                    <x-material-icon>
                        add
                    </x-material-icon>

                    {{ __('Add new') }}
                </x-button>
                <livewire:admin.posts.category-create wire:model="modalOpen" /> 
                </section>
            @endif
        </x-slot>
        
        <section class="py-4 border-b border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-secondary font-semibold text-gray-600 dark:text-zinc-300">
                {{ __('Search & Filters') }}
            </h3>
        </section>

        <section class="post-table overflow-x-hidden 2xl:overflow-x-visible">
            <x-resource-table>
                <x-slot name="tableHead">
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Name') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Created at') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Updated at') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Action') }}
                    </th>
                </x-slot>
                @foreach ($resource as $category)
                    <tr class="resource-tr" wire:key="{{ $category->getKey() }}">
                        <td class="w-4 mx-auto text-center p-4">{{ $category->getKey() }}</td>
                        <td class="p-4">{{ $category->getName() }}</td>
                        <td class="p-4">{{ $category->created_at }}</td>
                        <td class="p-4">{{ $category->updated_at }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-center">
                                @if ($loggedInUser->can('view-category'))
                                    <section>
                                        <x-iconed-link 
                                            icon="visibility" 
                                            :link="route('admin.posts.categories.show', ['category' => $category])" 
                                            icon_size="md"
                                            class="button mr-2" />
                                    </section>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-resource-table>
        </section>

        @if(blank($resource))
            <h3 class="font-primary text-lg text-gray-600 lowercase text-center my-5">
                {{ __('No categories found.') }}
            </h3>
        @endif 
    </x-admin-card>

    <x-pagination-links :$resource />
</section>
