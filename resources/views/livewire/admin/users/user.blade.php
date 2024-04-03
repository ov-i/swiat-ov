<section>
    <x-back-button :to="route('admin.dashboard')">
        {{ __('Back to dashboard') }}
    </x-back-button>

    <x-admin-card title="Users">
        <section class="py-4 border-b border-gray-200">
            <h3 class="text-lg font-secondary font-semibold text-gray-600 dark:text-zinc-300">
                {{ __('Search & Filters') }}
            </h3>
        </section>

        <section class="searchable-actions">
            <x-search-model :state="$state" />
        </section>

        <section>
            <x-resource-table>
                <x-slot name="tableHead">
                    <th scope="col" class="px-6 py-3">
                        {{ __('#') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Name') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Status') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Ip') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Locked') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Action') }}
                    </th>
                </x-slot>

                @foreach ($resource as $user)
                    <tr class="resource-tr" wire:key="{{ $user->getKey() }}">
                        <td class="w-4 p-4">{{ $user->getKey() }}</td>
                        <td
                            scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="{{ $user->profile_photo_url }}"
                                alt="User avatar image">
                            <div class="ps-3">
                                <div class="text-base font-semibold">
                                    <a href="{{ route('admin.users.show', ['user' => $user]) }}"
                                        class="hover:text-gray-600 transition duration-100">
                                        {{ $user->getName() }}
                                    </a>
                                </div>
                                <div class="font-normal text-gray-500">{{ $user->getEmail() }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <livewire:user-activity :$user />
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->getIp() }}
                        </td>
                        <td class="px-6 py-4">
                            <x-user-locked :$user />
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
                                                icon="info"
                                                link="{{ route('admin.users.show', ['user' => $user]) }}">
                                                {{ __('Show info') }}
                                            </x-iconed-link>

                                        </li> <!-- end item -->

                                        <!-- single list item -->
                                        <li>
                                            <x-iconed-link 
                                                content="Edit user" 
                                                icon="edit"
                                                link="{{ route('admin.users.edit', ['user' => $user]) }}">
                                                {{ __('Edit user') }}
                                            </x-iconed-link>
                                        </li> <!-- end item -->

                                        <!-- single list item -->
                                        <li>
                                            <button type="button" 
                                                class="flex cursor-pointer hover:text-gray-600 flex-row items-center text-md"
                                                wire:click="delete({{ $user->getKey() }})"
                                                wire:confirm="Soft delete this user?">
                                                <x-material-icon classes="text-sm">
                                                    delete
                                                </x-material-icon>

                                                {{ __('Delete user') }}
                                            </button>
                                        </li> <!-- end item -->
                                    </ul> <!-- end actions list -->
                                </x-slot>
                            </x-dropdown>
                        </td>
                    </tr>
                @endforeach
            </x-resource-table>
        </section>
    </x-admin-card>

    <x-pagination-links :$resource />
</section>
