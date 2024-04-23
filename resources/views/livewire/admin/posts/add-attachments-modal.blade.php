<section>
    <x-button type="button" class="text-sm md:text-md lg:text-base" wire:click="openModal()">
        <x-material-icon>
            attach_file_add
        </x-material-icon>

        {{ __('Add new') }}
    </x-button>

    <x-modal wire:model="modalOpen">
        <section class="p-5 font-secondary">
            <h1 class="text-xl">Add new attachment</h1>

            <form wire:submit="addAttachments">
                <x-label for="fileInput" class="draggable-section w-full border-2 border-dashed px-10 py-20 my-3 h-full rounded-md hover:border-zinc-600 cursor-pointer transition-colors duration-200 ease-linear hover:bg-gray-300 hover:bg-opacity-40" id="draggableSection-admin">
                    <article class="draggable-wrapper relative text-center">
                        <h1 class="text-2xl mb-3">{{ __('Drag & Drop here') }}</h1>
                        <p class="text-lg text-zinc-400">
                            {{ __('or click to add attachment[s] that you want.') }}
                        </p>
                        <input 
                            type="file" 
                            name="attachments[]" 
                            id="fileInput"
                            class="hidden"
                            accept="{{ implode(',', $this->getAllowedMimeTypes()) }}"
                            size="{{ config('swiatov.max_file_size') }}" 
                            wire:model.live.throttle="addAttachmentForm.attachments"
                            multiple />
                    </article>
                </x-label>
                
                <x-button
                    :disabled="count($addAttachmentForm->attachments) < 1"
                    class="mb-4"
                    wire:loading.remove>
                    {{ __('submit') }}
                </x-button>
            
                <x-button
                    disabled
                    wire:loading.flex>
                    <x-material-icon class="animate-spin">
                        sync
                    </x-material-icon>
                </x-button>

                <x-input-error for="addAttachmentForm.attachments.*" />

            </form>
            
            <livewire:admin.posts.attachments.attachment-preview wire:model.live="addAttachmentForm.attachments" />
        </section>
    </x-modal>
</section>

