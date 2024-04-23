<x-.relation button-text="Add attachments" :link="route('admin.attachments')">
    <x-.relation.table :relation="$this->getAttachments()" resource="attachments">
        <x-resource-table.head>
            <x-resource-table.header>#</x-resource-table.header>
            <x-resource-table.header>Original name</x-resource-table.header>
            <x-resource-table.header>Mime type</x-resource-table.header>
            <x-resource-table.header>Size</x-resource-table.header>
            <x-resource-table.header>Action</x-resource-table.header>
        </x-resource-table.head>

        <x-resource-table.body>
            @forelse ($this->getAttachments() as $attachment)
                <x-resource-table.row :resource="$attachment" :key="$attachment->getKey()">
                    <x-resource-table.cell>
                        {{ $attachment->getKey() }}
                    </x-resource-table.cell>

                    <x-resource-table.cell>
                        {{ $attachment->getOriginalName() }}
                    </x-resource-table.cell>

                    <x-resource-table.cell>
                        {{ $attachment->getMimeType() }}
                    </x-resource-table.cell>

                    <x-resource-table.cell>
                        {{ $this->fileSize($attachment->getSize()) }}
                    </x-resource-table.cell>

                    <x-resource-table.cell>
                        <x-admin-card.actions :link="route('admin.attachments.show', ['attachment' => $attachment])" icon="visibility" />
                    </x-resource-table.cell>
                </x-resource-table.row>
            @empty
            @endforelse
        </x-resource-table.body>
    </x-.relation.table>
</x-.relation>