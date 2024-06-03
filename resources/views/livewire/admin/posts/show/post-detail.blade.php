@section('title')
    Edit: {{ $post->getTitle() }}
@endsection

<section>
    <x-admin-card title="" class="mt-2 w-full overflow-x-auto">
        <div class="post-details w-full">
            <x-resource-detail property='id' :value="$post->getKey()" />

            <x-resource-detail 
                property='user' 
                :value="$this->getPostUser()" 
                isLink="true" 
                :to="route('admin.users.show', ['user' => $this->getPostUser()])"
                title="{{ $this->getPostUser()->getName()}} ({{ $this->getPostUser()->getEmail() }})"
            />

            <x-resource-detail 
                property='category' 
                :value="$this->getCategory()" 
                isLink="true" 
                :to="route('admin.posts.categories', ['category' => $this->getCategory()])"/>

            <x-resource-detail 
                property='title' 
                :value="$post->getTitle()" />

            @if(filled($this->getThumbnail()))
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
            @endif

            <x-resource-detail property='slug' :value="$post->toSlug()" />

            @if (!$post->isEvent())
                <x-resource-detail property='excerpt' :value="$post->getExcerpt()" />
            @endif

            <x-resource-detail property='type' :value="$post->getType()" />

            <x-resource-detail property='content'>
                <x-slot name="value">
                    @if ($post->isEvent())
                        {{ $post->getContent() }}
                    @else
                        <button 
                            component="button" 
                            class="text-cyan-500 text-md" 
                            wire:click="openModal()">
                            {{ __('Show content') }}
                        </button>
                        <x-modal wire:model="modalOpen">
                            <section class="p-5 font-secondary">
                                {{ $post->getContent() }}
                            </section>
                        </x-modal>
                    @endif
                </x-slot>
            </x-resource-detail>
            
            <x-resource-detail property='archived'>
                <x-slot name="value">
                    <x-fields.boolean-field condition="{{ $post->isArchived() }}" />
                </x-slot>
            </x-resource-detail>

            <x-resource-detail class="whitespace-nowrap" property='archived_at' :value="$post->getArchivedAt()" x-show="$wire.posts.archived" />

            <x-resource-detail class="whitespace-nowrap" property='publishing in' :value="$this->getPublishDelay()" help="Post publishing is delayed for" x-show="$wire.posts.should_be_published_at "/>

            <x-resource-detail class="whitespace-nowrap" property='created at' :value="$post->created_at" />
                
            <x-resource-detail class="whitespace-nowrap" property='deleted at' :value="$post->deleted_at" />
        </div>
    </x-admin-card>

    <section class="relations">
        {{-- Attachments --}}
        <livewire:admin.posts.show.relations.attachments :$post />

        {{-- Tags --}}
        <livewire:admin.posts.show.relations.tags :$post />
    </section>
</section>
