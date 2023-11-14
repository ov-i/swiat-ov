<section class="bg-white rounded-md w-2/4 mx-auto p-3 my-2">
    <div class="filter-wrapper border-b mb-10">
        <section class="filter-header my-3">
            <x-section-title>
                <x-slot name="title">
                    <h2 class="text-2xl">Filtry wyszukujące</h2>
                </x-slot>
                <x-slot name="description">Wyszukaj lub filtruj użytkowników</x-slot>
            </x-section-title>
        </section>
        <section class="filters my-5 flex flex-row mb-10">
            <x-dropdown-filter :collection="$availableRoles" placeholder="wybierz rolę" />
            <x-dropdown-filter :collection="$availableRoles" placeholder="wybierz status" />
            <x-dropdown-filter :collection="$availableRoles" placeholder="wybierz plan" />
        </section>
    </div>
    <div class="users-table">
        <table class="min-w-full mb-0">
            <thead class="border-b bg-gray-50 rounded-t-lg text-left">
                <tr>
                    <th scope="col" class="rounded-tl-lg text-sm font-medium px-6 py-4">
                        <x-checkbox />
                    </th>
                    <th scope="col" class="rounded-tl-lg text-sm font-medium px-6 py-4">NAME</th>
                    <th scope="col" class="text-sm font-medium px-6 py-4">Adres ip</th>
                    <th scope="col" class="text-sm font-medium px-6 py-4">STATUS</th>
                    <th scope="col" class="text-sm font-medium px-6 py-4">ROLE</th>
                    <th scope="col" class="rounded-tr-lg text-sm font-medium px-6 py-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="align-middle text-sm font-normal px-6 py-4 whitespace-nowrap text-left">
                            <x-checkbox />
                        </td>
                        <th scope="row" class="text-sm font-normal px-6 py-4 whitespace-nowrap text-left">
                            <div class="flex flex-row items-center">
                                <img
                                    class="rounded-full w-12"
                                    src="{{ $user->profile_photo_url ?? Gravatar::src($user->email) }}" {{-- TODO: Implement Gravatar --}}
                                    alt="Avatar"
                                />
                                <div class="ml-4">
                                    <p class="mb-0.5 font-medium">{{ $user->name }}</p>
                                    <p class="mb-0.5 text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </th>
                        <td class="text-sm font-normal px-6 py-4 whitespace-nowrap text-left">
                            <div class="flex flex-col">
                                <p class="mb-0.5">{{ $user->ip }}</p>
                                <p class="mb-0.5 text-gray-500">Zabrze, Woj. Śląskie</p>
                            </div>
                        </td>
                        <td class="align-middle text-sm font-normal px-6 py-4 whitespace-nowrap text-left">
                            <span class="text-xs py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-medium {{ $user->isBlocked() ? 'bg-red-100 text-red-800' : 
                                'bg-green-100 text-green-800'
                            }} rounded-full">
                            {{ $user->isBlocked() ? 'Zablokowany' : 'Aktywny' }}
                            </span>
                        </td>
                        <td class="align-middle text-gray-500 text-sm font-normal px-6 py-4 whitespace-nowrap text-left">
                            @foreach ($user->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </td>
                        <td class="align-middle text-sm font-normal px-6 py-4 whitespace-nowrap text-left">
                            <a href="#!" class="font-medium text-red-600 hover:text-red-700 focus:text-red-700 active:text-red-800 transition duration-300 ease-in-out">
                                <x-dialog-modal>
                                    <x-slot name="title">dasdsad</x-slot>
                                    <x-slot name="content">dasdsad</x-slot>
                                    <x-slot name="footer">dasdsad</x-slot>
                                </x-dialog-modal>
                            </a>
                            <a href="#!" class="font-medium text-blue-600 hover:text-blue-700 focus:text-blue-700 active:text-blue-800 transition duration-300 ease-in-out">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</section>