<section>
    <livewire:admin.resource-detail resourceName="user" :resourceClass="$user" />

    <x-admin-card.index title="" class="mt-2">
        <div class="user-details">
            <x-resource-detail property='id' :value="$this->user()->getKey()" />
            <x-resource-detail property='name' :value="$this->user()->getName()" />
            <x-resource-detail property='email' :value="$this->user()->getEmail()" isLink="true" to="mailto: {{ $this->user()->getEmail() }}"/>
            <x-resource-detail property='verified at' :value="$this->user()->email_verified_at" />
            <x-resource-detail property='preferred theme' :value="$this->user()->getTheme()" />
            <x-resource-detail property='status' help="Current user account status (active / banned)">
                <x-slot name="value">
                    <x-fields.boolean-field condition="{{ !$this->user()->isBlocked() }}" />
                </x-slot>
            </x-resource-detail>
            <x-resource-detail property='verified' help="Is email address verified">
                <x-slot name="value">
                    <x-fields.boolean-field condition="{{ $this->user()->hasVerifiedEmail() }}" />
                </x-slot>
            </x-resource-detail>
            <x-resource-detail property='created at' :value="$this->user()->created_at" />
            <x-resource-detail property='deleted at' :value="$this->user()->deleted_at" />
        </div>
    </x-admin-card.index>

    <section class="relations">
        <x-resource-relation title="roles" withId="false">
            <x-slot:actions>
                <x-button class="text-sm">Add role</x-button>
            </x-slot:actions>

            <x-resource-table.head>
                <x-resource-table.header>Name</x-resource-table.header>
                <x-resource-table.header>Guard name</x-resource-table.header>
                <x-resource-table.header>Action</x-resource-table.header>
            </x-resource-table.head>

            <x-resource-table.body>
                @foreach ($this->getRoles() as $role)
                <x-resource-table.row :resource="$role" :key="$role->getKey()">
                    <td class="text-xs py-3 md:text-base">{{ $role->name }}</td>
                    <td class="text-xs py-3 md:text-base">{{ $role->guard_name }}</td>
                    <td class="text-xs py-3 md:text-base">
                        {{-- <x-iconed-link :link="route('')" icon="visibility" /> --}}
                    </td>
                </x-resource-table.row>
                @endforeach
            </x-resource-table.body>
        </x-resource-relation>
        
        <x-resource-relation title="posts">
            <x-slot:actions>
                <x-button class="text-sm">Add role</x-button>
            </x-slot:actions>

            <x-resource-table.head>
                <x-resource-table.header>#</x-resource-table.header>
                <x-resource-table.header>Title</x-resource-table.header>
                <x-resource-table.header>Type</x-resource-table.header>
                <x-resource-table.header>Status</x-resource-table.header>
                <x-resource-table.header>Action</x-resource-table.header>
            </x-resource-table.head>

            <x-resource-table.body>
                @foreach ($this->getPosts() as $post)
                <x-resource-table.row :resource="$post" :key="$post->getKey()">
                    <td class="py-3 text-xs md:text-base">{{ $post->getKey() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $post->getTitle() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $post->getType() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $post->getStatus() }}</td>
                    <td class="py-3 text-xs md:text-base">
                        <x-iconed-link :link="route('admin.posts.show', ['post' => $post])" icon="visibility" icon_size='md' />
                    </td>
                </x-resource-table.row>
                @endforeach
            </x-resource-table.body>
        </x-resource-relation>

        <x-resource-relation title='attachments'>
            <x-slot:actions>
                <x-button class="text-sm">Add role</x-button>
            </x-slot:actions>

            <x-resource-table.head>
                <x-resource-table.header>#</x-resource-table.header>
                <x-resource-table.header>Original name</x-resource-table.header>
                <x-resource-table.header>Mime type</x-resource-table.header>
                <x-resource-table.header>Size</x-resource-table.header>
                <x-resource-table.header>Action</x-resource-table.header>
            </x-resource-table.head>

            <x-resource-table.body>
                @foreach ($this->getAttachments() as $attachment)
                <x-resource-table.row :resource="$attachment" :key="$attachment->getKey()">
                    <td class="py-3 text-xs md:text-base">{{ $attachment->getKey() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $attachment->getOriginalName() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $attachment->getMimeType() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $this->fileSize($attachment->getSize()) }}</td>
                    <td class="py-3 text-xs md:text-base">
                        <x-material-icon>
                            visibility
                        </x-material-icon>
                    </td>
                </x-resource-table.row>
                @endforeach
            </x-resource-table.body>
        </x-resource-relation>
    </section>
</section>
