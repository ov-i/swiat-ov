<section>
    <livewire:admin.resource-detail resourceName="user" :resourceClass="$user" />

    <x-admin-card title="" class="mt-2">
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
    </x-admin-card>

    <section class="relations">
        <x-resource-relation title="roles" withId="false">
            <x-slot:actions>
                <x-button class="text-sm">Add role</x-button>
            </x-slot:actions>

            <x-slot name="tableHead">
                <th scope="col" class="py-3 text-xs md:text-md text-left">Name</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Guard name</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Action</th>
            </x-slot>

            @foreach ($this->getRoles() as $role)
                <tr class="text-left text-sm resource-tr" wire:key="{{ $role->getKey() }}">
                    <td class="text-xs py-3 md:text-base">{{ $role->name }}</td>
                    <td class="text-xs py-3 md:text-base">{{ $role->guard_name }}</td>
                    <td class="text-xs py-3 md:text-base">
                        {{-- <x-iconed-link :link="route('')" icon="visibility" /> --}}
                    </td>
                </tr>
            @endforeach
        </x-resource-relation>
        
        <x-resource-relation title="posts">
            <x-slot:actions>
                <x-button class="text-sm">Add role</x-button>
            </x-slot:actions>

            <x-slot name="tableHead">
                <th scope="col" class="py-3 text-xs md:text-md text-left">#</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Title</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Type</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Status</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Action</th>
            </x-slot>
            
            @forelse ($this->getPosts() as $post)
                <tr class="text-left text-sm resource-tr">
                    <td class="py-3 text-xs md:text-base">{{ $post->getKey() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $post->getTitle() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $post->getType() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $post->getStatus() }}</td>
                    <td class="py-3 text-xs md:text-base">
                        <x-iconed-link :link="route('admin.posts.show', ['post' => $post])" icon="visibility" icon_size='md' />
                    </td>
                </tr>    
            @empty
            @endforelse
        </x-resource-relation>

        <x-resource-relation title='attachments'>
            <x-slot:actions>
                <x-button class="text-sm">Add role</x-button>
            </x-slot:actions>

            <x-slot name="tableHead">
                <th scope="col" class="py-3 text-xs md:text-md text-left">#</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Original name</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Mime type</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Size</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">Action</th>
            </x-slot>

            @forelse ($this->getAttachments() as $attachment)
                <tr class="text-left text-sm resource-tr" wire:key="{{ $attachment->getKey() }}">
                    <td class="py-3 text-xs md:text-base">{{ $attachment->getKey() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $attachment->getOriginalName() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $attachment->getMimeType() }}</td>
                    <td class="py-3 text-xs md:text-base">{{ $this->fileSize($attachment->getSize()) }}</td>
                    <td class="py-3 text-xs md:text-base">
                        <x-material-icon>
                            visibility
                        </x-material-icon>
                    </td>
                </tr>
            @empty
            @endforelse
        </x-resource-relation>
    </section>
</section>
