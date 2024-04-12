@props(['post'])

<x-menu>
    <x-menu.button class="rounded hover:bg-gray-100 p-1">
        <x-icon.ellipsis-horizontal />
    </x-menu.button>

    <x-menu.items>
        <x-menu.close>
            <x-menu.link :link="route('admin.posts.edit', ['post' => $post])">
                <x-icon.pencil-square />
                Edit
            </x-menu.link>
        </x-menu.close>

        <x-menu.close>
            <x-menu.item 
              wire:click="delete({{ $post->getKey() }})"
              wire:confirm="Are you sure you want to delete this post?"
            >
              <x-icon.trash />
              Delete
            </x-menu.item>
        </x-menu.close>
    </x-menu.items>
</x-menu>