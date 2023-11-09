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
        <table class="w-full first:text-left text-center">
            <thead class="bg-gray-300">
                <tr>
                    <th><x-checkbox /></th>
                    <th>Użytkownik</th>
                    <th>Rola</th>
                    <th>Adres IP</th>
                    <th>Akcja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><x-checkbox /></td>
                        <td>
                            <div class="flex flex-row my-2">
                                <div class="avatar-img mr-2">
                                    <img 
                                        src="{{ $user->profile_photo_path }}" 
                                        alt="User avatar" 
                                        class="w-12 h-12 rounded-full shadow"
                                    >
                                </div>
                                <div class="details">
                                    <p>{{ $user->name }}</p>
                                    <span class="text-muted">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @foreach ($user->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </td>
                        <td>{{ $user->ip }}</td>
                        <td>
                            <x-dropdown-link>
                                <x-dropdown class="cursor-pointer">
                                    <x-slot name="trigger">
                                        <span class="cursor-pointer">akcja</span>
                                    </x-slot>
                                    <x-slot name="content">
                                        <ul class="list-none">
                                            <li class="cursor-pointer">zobacz</li>
                                            <li class="cursor-pointer">edytuj</li>
                                            <li class="cursor-pointer">usuń</li>
                                        </ul>
                                    </x-slot>
                                </x-dropdown>
                            </x-dropdown-link>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</section>