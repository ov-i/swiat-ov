<x-relation button-text="Add tags" :link="route('admin.posts.tags')">
    <x-relation.table :relation="$this->getTags()" resource="tags">
        <x-resource-table.head>
            <x-resource-table.header>#</x-resource-table.header>
            <x-resource-table.header>Original name</x-resource-table.header>
            <x-resource-table.header>Mime type</x-resource-table.header>
            <x-resource-table.header>Size</x-resource-table.header>
            <x-resource-table.header>Action</x-resource-table.header>
        </x-resource-table.head>

        <x-resource-table.body>
            @forelse ($this->getTags() as $tag)
                <x-resource-table.row :resource="$tag" :key="$tag->getKey()">
                    <x-resource-table.cell>
                        {{ $tag->getKey() }}
                    </x-resource-table.cell>

                    <x-resource-table.cell>
                        {{ $tag->getName() }}
                    </x-resource-table.cell>

                    <x-resource-table.cell>
                        <x-admin-card.actions :link="route('admin.attachments.show', ['attachment' => $attachment])" icon="visibility" />
                    </x-resource-table.cell>
                </x-resource-table.row>
            @empty
            @endforelse
        </x-resource-table.body>
    </x-relation.table>
</x-relation>