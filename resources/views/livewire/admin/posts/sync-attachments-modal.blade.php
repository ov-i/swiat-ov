<x-modal wire:model.live="attachmentsModal">
    <form wire:submit.prevent="save">
        <section class="wrapper flex flex-col p-5 font-secondary">
            @if (filled($this->attachments()))
                <div class="header flex items-center justify-between">
                    <h2 class="font-secondary text-lg dark:text-white">
                        {{ __('Sync attachments') }}
                    </h2>

                    <x-button component="button-zinc-outlined" class="py-2 px-3" >
                        save
                    </x-button>
                </div>
                
                <x-input-error for="attachmentsToSync.*" />

                <section class="summary py-3" x-show="$wire.attachments.length">
                    <article class="flex items-center w-full justify-between">
                        <h3 class="text-md text-gray-600 dark:text-zinc-400">
                            {{ $attachmentsToSync->count() }} Item(s)
                        </h3>
                        <section class="only-selected">
                            <x-input type="checkbox" id="only-selected-input" :disabled="!$attachmentsToSync->count()" wire:model.live="showOnlySelected" />
                            <x-label for="only-selected-input" :value="__('Show only selected')" class="inline" />
                        </section>
                    </article>
                </section>
                <x-input-error for="attachmentsToSync.*" />
                <section class="summary py-3" x-show="$wire.attachments.length">
                    <article class="flex items-center w-full justify-between">
                        <h3 class="text-md text-gray-600 dark:text-zinc-400">
                            {{ $attachmentsToSync->count() }} Item(s)
                        </h3>
                        <section class="only-selected">
                            <x-input type="checkbox" id="only-selected-input" :disabled="!$attachmentsToSync->count()" wire:model.live="showOnlySelected" />
                            <x-label for="only-selected-input" :value="__('Show only selected')" class="inline" />
                        </section>
                    </article>
                </section>
            @endif
            
            @forelse ($this->attachments() as $attachment)
                <section class="flex justify-between items-center border-b dark:border-gray-600 last:border-none py-4">
                    <section class="flex items-start py-2">
                        <article class="left-side pr-2">
                            <img src="{{ $attachment->getPublicUrl() }}" alt="{{ __('Attachment image') }}" class="w-20 object-cover h-12">
                        </article>
                        <article class="right-side">
                            <h2 class="text-sm md:text-md dark:text-zinc-200">
                                {{ $this->substringIf($attachment->getFileName(), stringLength: 40) }}
                            </h2>
                            <p class="font-light text-sm dark:text-zinc-200">
                                {{ $attachment->getMimeType() }}, {{ $this->fileSize($attachment->getSize()) }}
                            </p>
                        </article>
                    </section>
                    @if (!$showOnlySelected)
                        <section>
                            <x-button 
                                type="button"
                                :component="$this->isAdded($attachment->getKey()) ? 'button-info' : 'button-info-outlined'"
                                class="p-2" 
                                wire:click="toggle({{ $attachment->getKey() }})">
                                <x-material-icon>
                                    {{ $this->isAdded($attachment->getKey()) ? 'done' : 'add' }}
                                </x-material-icon>
                            </x-button>
                        </section>
                    @endif
                </section>
            @empty
                <section class="flex justify-center items-center py-4">
                    <p class="text-gray-600 dark:text-zinc-400">
                        {{ __('No attachments found') }}
                    </p>
                </section>
            @endforelse
        </section>
    </form>
</x-modal>