<section>
    <livewire:admin.resource-detail resourceName="post" :resourceClass="$post" />

    <x-admin-card title="" class="mt-2">
        <div class="post-details">
            <x-resource-detail property='id' :value="$this->post()->getKey()" />
            <x-resource-detail 
                property='user' 
                :value="$this->getPostUser()" 
                isLink="true" 
                :to="route('admin.users.show', ['user' => $this->getPostUser()])"/>

            <x-resource-detail 
                property='category' 
                :value="$this->getCategory()" 
                isLink="true" 
                :to="route('admin.posts.categories', ['category' => $this->getCategory()])"/>

            <x-resource-detail property='title' :value="$this->post()->getTitle()" />
            <x-resource-detail property='thumbnail'>
                <x-slot name="value">
                    <x-button component="button" wire:click="showImageModel = true" type="button">
                        <img src="{{ $this->getThumbnail() }}" alt="post thumbnail" class="w-20 h-20">
                    </x-button>

                    <x-modal wire:model="showImageModel">
                        <section class="p-5">
                            <img src="{{ $this->getThumbnail() }}" alt="" class="object-cover">
                        </section>
                    </x-modal>
                </x-slot>
            </x-resource-detail>
            <x-resource-detail property='slug' :value="$this->post()->toSlug()" />
            <x-resource-detail property='excerpt' :value="$this->post()->getExcerpt()" />
            <x-resource-detail property='type' :value="$this->post()->getType()" />
            <x-resource-detail property='content'>
                <x-slot name="value">
                    <button 
                        component="button" 
                        class="text-cyan-500 text-md" 
                        wire:click="openModal()">
                        {{ __('Show content') }}
                    </button>
                    <x-modal wire:model="modalOpen">
                        <section class="p-5 font-secondary">
                            {{ $this->post()->getContent() }}
                        </section>
                    </x-modal>
                </x-slot>
            </x-resource-detail>
            <x-resource-detail property='archived'>
                <x-slot name="value">
                    <x-fields.boolean-field condition="{{ $this->post()->isArchived() }}" />
                </x-slot>
            </x-resource-detail>
            <x-resource-detail property='archived_at' :value="$this->post()->getArchivedAt()" x-show="$wire.posts.archived" />
            <x-resource-detail property='publishing in' :value="$this->getPublishDelay()" help="Post publishing is delayed for" x-show="$wire.posts.should_be_published_at "/>
            <x-resource-detail property='created at' :value="$this->post()->created_at" />
            <x-resource-detail property='deleted at' :value="$this->post()->deleted_at" />
        </div>
    </x-admin-card>

    <section class="relations">
        <x-resource-relation title='attachments'>
            <x-slot:actions>
                <x-button class="text-sm">Add attachment</x-button>
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
                        <x-iconed-link :link="route('admin.attachments.show', ['attachment' => $attachment])" icon="visibility" icon_size="md" />
                    </td>
                </tr>
            @empty
            @endforelse
        </x-resource-relation>
    </section>
</section>
