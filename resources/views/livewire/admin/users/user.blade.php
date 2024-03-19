<section class="user-table font-secondary">
    @if (session()->has('user-deleted'))
        <div class="bg-green-600 text-white text-center rounded-md p-3 mb-3">
            {{ session()->get('user-deleted') }}
        </div>
    @endif
    @if (session()->has('adminIsNotDeleteable'))
        <div class="bg-red 600 text-white text-center rounded">
            {{ session()->get('adminIsNotDeleteable') }}
        </div>
    @endif

    <article class="bg-white w-full p-4 rounded-md shadow">
        <h3 class="text-lg font-semibold text-gray-600">{{ __('Search Filter') }}</h3>

        <!-- User table filter -->
        <section
            class="user-table-filters w-full flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 lg:space-x-3 py-5 lg:py-7 border-b border-gray-200 ">
            <div class="table-filter w-full">
                <x-expandable-button title="Select role">
                    <x-slot name="content">
                        <ul>
                            <li>Admin</li>
                            <li>Moderator</li>
                            <li>User</li>
                        </ul>
                    </x-slot>
                </x-expandable-button>
            </div>

            <div class="table-filter w-full">
                <x-expandable-button title="Select status">
                    <x-slot name="content">
                        <ul>
                            <li>Trashed</li>
                            <li>Active</li>
                            <li>Offline</li>
                        </ul>
                    </x-slot>
                </x-expandable-button>
            </div>

            <div class="table-filter w-full">
                <x-expandable-button title="Select Plan">
                    <x-slot name="content">
                        <ul>
                            <li>Standrad</li>
                            <li>Developer</li>
                            <li>Extended</li>
                        </ul>
                    </x-slot>
                </x-expandable-button>
            </div>
        </section> <!-- end table filters -->

        {{-- <!-- Table actions -->
        <section class="table-actions">
            <livewire:tables.table-actions />
        </section> <!-- end table actions --> --}}

        <section class="table-content w-full overflow-x-scroll md:overflow-visible">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <label for="checkbox-all-search" class="sr-only">
                                    checkbox
                                </label>
                                <x-checkbox id="checkbox-all-search" />
                            </div>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-white border-b last:border-none dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            wire:key="{{ $user->id }}">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    <x-checkbox id="checkbox-table-search-1" />
                                </div>
                            </td>
                            <td scope="row"
                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="{{ $user->profile_photo_url }}"
                                    alt="Jese image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">
                                        <a href="{{ route('admin.users.show', ['user' => $user]) }}"
                                            class="hover:text-gray-600 transition duration-100">
                                            {{ $user->name }}
                                        </a>
                                    </div>
                                    <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <x-user-activity :activityService="$activityService" :user="$user" />
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->ip }}
                            </td>
                            <td class="px-6 py-4">
                                <x-user-locked :user="$user" />
                            </td>
                            <td class="px-6 py-4">
                                <x-dropdown align="left">
                                    <x-slot name="trigger">
                                        <span class="material-symbols-outlined text-xl cursor-pointer">
                                            more_vert
                                        </span>
                                    </x-slot>
                                    <x-slot name="content">
                                        <!-- Actions list -->
                                        <ul class="space-y-2 text-md">

                                            <!-- single list item -->
                                            <li>
                                                <x-iconed-link content="Show info" icon="info"
                                                    link="{{ route('admin.users.show', ['user' => $user]) }}" />
                                            </li> <!-- end item -->

                                            <!-- single list item -->
                                            <li>
                                                <x-iconed-link content="Edit user" icon="edit"
                                                    link="{{ route('admin.users.edit', ['user' => $user]) }}" />
                                            </li> <!-- end item -->

                                            <!-- single list item -->
                                            <li>
                                                <div class="flex cursor-pointer hover:text-gray-600 flex-row items-center text-md"
                                                    wire:click="delete({{ $user->id }})"
                                                    wire:confirm="Soft delete this user?">
                                                    <span class="material-symbols-outlined text-sm mr-2">
                                                        delete
                                                    </span>

                                                    {{ __('Delete user') }}
                                                </div>
                                            </li> <!-- end item -->
                                        </ul> <!-- end actions list -->
                                    </x-slot>
                                </x-dropdown>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="table-pagination">
            <!-- links -->
            {{ $users->links() }}
        </section>
    </article>
</section>
