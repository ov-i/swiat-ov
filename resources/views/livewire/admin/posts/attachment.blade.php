<section>
    <x-back-button :to="route('admin.dashboard')">
        {{ __('Back to dashboard') }}
    </x-back-button>

    <x-admin-card.index :title="__('Attachments')">
        <x-slot name="actions">
            <section class="hidden md:block">
                @if (auth()->user()->can('create-attachment'))
                    @livewire('admin.posts.add-attachments-modal')
                @endif
            </section>
        </x-slot>

        <div class="border-b w-full h-2 my-3 border-gray-200"></div>

        <section class="file-list mb-4 py-4 w-full">
            <ul class="w-full">
                @forelse ($resource as $attachment)
                    <x-dotted-list liClass="py-4 first:pt-0 last:pb-0">
                        <article class="file-info flex items-center">
                                <x-material-icon>
                                    attach_file
                                </x-material-icon>
                                
                                <a href="{{ route('admin.attachments.show', [
                                    'attachment' => $attachment->getChecksum()
                                ]) }}" class="text-md">
                                    {{ $attachment->getOriginalName() }}
                                </a>
                            </article>
                            <article class="items-center hidden lg:flex">
                                <p class="px-2 first:pl-0 last:pr-0 border-r last:border-none italic">
                                    size: 
                                    <span>
                                        {{ $this->fileSize($attachment->getSize()) }}
                                    </span>
                                </p>
                                <p class="px-2 first:pl-0 last:pr-0 border-r last:border-none italic">
                                    mime: 
                                    <span>
                                        {{ $this->substringIf($attachment->getMimeType(), 16)}}
                                    </span>
                                </p>
                            </article>
                            <article class="lg:hidden flex items-center">
                                <x-iconed-link 
                                    :link="route('admin.attachments.show', [
                                        'attachment' => $attachment->getChecksum()
                                    ])" 
                                    icon="visibility" 
                                    icon_size="md" />
                            </article>
                    </x-dotted-list> 
                @empty
                    <div>
                        <h1 class="text-lg text-center">No attachments were found</h1>
                    </div>
                @endforelse
            </ul>
        </section>

        <section class="md:hidden">
            @livewire('admin.posts.add-attachments-modal')
        </section>
    </x-admin-card.index>

    <x-pagination-links :$resource />
</section>
