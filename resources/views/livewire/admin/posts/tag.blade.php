@php
    $loggedInUser = auth()->user();
@endphp

<section>
    <x-back-button :to="route('admin.dashboard')">
        {{ __('Back to dashboard') }}
    </x-back-button>

    <x-admin-card title="Posts">
        <x-slot name="actions">
            @if ($loggedInUser->can('write-tag'))
                <section>
                    <x-button type="button" class="text-sm md:text-md lg:text-base" wire:click="openModal()">
                    <x-material-icon>
                        add
                    </x-material-icon>

                    {{ __('Add new') }}
                </x-button>
                <livewire:admin.posts.tags-create wire:model="modalOpen" /> 
                </section>
            @endif
        </x-slot>

        <section class="post-table overflow-x-hidden 2xl:overflow-x-visible mt-5">
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
                </x-slot>

                @foreach ($resource as $tag)
                    <tr class="resource-tr" wire:key="{{ $tag->getKey() }}">
                        <td class="w-4 p-4">{{ $tag->getKey() }}</td>
                        <td class="px-6 py-4">{{ $tag->getName() }}</td>
                        <td class="px-6 py-4">{{ $tag->created_at }}</td>
                        <td class="px-6 py-4">{{ $tag->updated_at }}</td>
                    </tr>
                @endforeach
            </x-resource-table>
        </section>

        @if (blank($resource))
            <h3 class="font-primary text-lg text-gray-600 lowercase text-center my-5">
                {{ __('No tags found, ') }}
                <a href="{{ route('admin.posts.tags.create') }}"
                    class="text-cyan-500 underlined hover:text-cyan-700 active:text-cyan-800 dark:text-white">
                    {{ __('create one here') }}
                </a>
            </h3>
        @endempty
    </x-admin-card>

    <x-pagination-links :$resource />
</section>
