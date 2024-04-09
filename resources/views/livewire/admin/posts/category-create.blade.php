<section>
    <x-modal wire:model.live="modalOpen">
        <section class="p-5 font-secondary">
            <h1 class="text-xl">Add new category</h1>

            <form wire:submit="addCategory" class="mt-4">
                <x-input wire:model.live="category" class="w-full" :placeholder="__('Category name')"/>
                <x-input-error for="category" /> 

                <div class="mt-4">
                     <x-button
                        wire:click="closeModal()"
                        wire:target="addCategory"
                        wire:loading.remove>
                        {{ __('submit') }}
                    </x-button>

                    <x-button 
                        wire:loading
                        wire:target="addCategory">
                        <x-material-icon class="animate-spin">
                            sync
                        </x-material-icon>
                    </x-button>
                </div>
            </form>
        </section>
    </x-modal>
</section>