@props(['post'])

<x-menu>
    <x-menu.button class="rounded hover:bg-gray-100 p-1">
        <x-icon.ellipsis-horizontal />
    </x-menu.button>

    <x-menu.items>
        @can('update', [\App\Models\Posts\Post::class, $post])
        <x-menu.close>
            <x-menu.link :link="route('admin.posts.edit', ['post' => $post])">
                <x-icon.pencil-square />
                Edit
            </x-menu.link>
        </x-menu.close>
        @endcan

        @if ($post->deleted_at === null)
            @can('delete', [\App\Models\Posts\Post::class, $post])
            <x-menu.close>
                <x-menu.item 
                    wire:click="delete({{ $post->getKey() }})"
                    wire:confirm="Are you sure you want to delete this post?"
                >
                    <x-icon.trash />
                    Delete
                </x-menu.item>
            </x-menu.close>    
            @endcan
        @else
            @can('restore', [\App\Models\Posts\Post::class, $post])
            <x-menu.close>
                <x-menu.item 
                    wire:click="restore({{ $post->getKey() }})"
                    wire:confirm="Restore this post?"
                >
                    <x-icon.receipt-refund />
                    Restore
                </x-menu.item>
            </x-menu.close>    
            @endcan
        @endif
    </x-menu.items>
</x-menu>