<section>
    <x-modal wire:model.live="modalOpen">
        <section class="p-5 font-secondary">
            <h1 class="text-xl">Add new tag</h1>

            <form wire:submit="addTag" class="mt-4">
                <x-input wire:model.live="tag" class="w-full" :placeholder="__('Tag name')"/>
                <x-input-error for="tag" /> 

                <div class="mt-4">
                     <x-button
                        wire:click="closeModal()"
                        wire:target="addTag"
                        wire:loading.remove>
                        {{ __('submit') }}
                    </x-button>

                    <x-button 
                        wire:loading
                        wire:target="addTag">
                        <x-material-icon class="animate-spin">
                            sync
                        </x-material-icon>
                    </x-button>
                </div>
            </form>
        </section>
    </x-modal>
</section>