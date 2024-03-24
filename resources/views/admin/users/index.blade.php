<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users list') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <section class="card-header bg-white p-3">
                <h2>Filtruj lub wyszukaj użytkowników</h2>
                <article class="filters">
                    <div class="filter">
                    </div>
                </article>
            </section>
            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>roles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @foreach($user->roles()->get() as $role)
                                {{ $role->name }}
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
