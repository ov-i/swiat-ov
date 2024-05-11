@props(['user'])

<x-menu>
    <x-menu.button class="rounded hover:bg-gray-100 dark:hover:bg-transparent p-1 dark:text-white dark:hover:text-gray-300 transition-colors">
        <x-icon.ellipsis-horizontal />
    </x-menu.button>

    <x-menu.items>
        @can('update', [\App\Models\User::class, $user])
        <x-menu.close>
            <x-menu.link :link="route('admin.users.edit', ['user' => $user])">
                <x-icon.pencil-square />
                Edit
            </x-menu.link>
        </x-menu.close>
        @endcan

        @if (blank($user->deleted_at))
            @can('delete', [\App\Models\User::class, $user])
            <x-menu.close>
                <x-menu.item 
                    wire:click="delete({{ $user->getKey() }})"
                    wire:confirm="Are you sure you want to delete this user?"
                >
                    <x-icon.trash />
                    Delete
                </x-menu.item>
            </x-menu.close>    
            @endcan
        @else
            @can('restore', [\App\Models\User::class, $user])
            <x-menu.close>
                <x-menu.item 
                    wire:click="restore({{ $user->getKey() }})"
                    wire:confirm="Restore this user?"
                >
                    <x-icon.receipt-refund />
                    Restore
                </x-menu.item>
            </x-menu.close>    
            @endcan
        @endif
    </x-menu.items>
</x-menu>