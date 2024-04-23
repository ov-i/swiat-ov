<div>
    <x-button type="button" component="button-zinc-outlined" class="mr-2" wire:click="openModal()">
        {{ __('Change status') }}
    </x-button>
    <x-modal wire:model="modalOpen">
        <section class="p-3 mx-auto font-primary">
            <h1 class="font-semibold text-xl border-b border-gray-200 pb-3 mb-3">{{ __('Select status') }}</h1>

            <x-select name="status" id="status" wire:model.live="newStatus" class="w-full">
                @foreach ($this->getAvailableExcplicitStatus() as $status)
                    <option 
                        value="{{ $status }}" 
                        {{ $this->post->getStatus() === $status  ? 'selected' : null}}>
                        {{ __($status->label()) }}
                    </option>
                @endforeach
            </x-select>

            <x-input-error for='newStatus' />

            <x-button 
                type="button" 
                wire:click="updateStatus" 
                class="my-3 text-sm" 
                wire:loading.remove>
                {{ __('Update') }}
            </x-button>

            <x-button 
                type="button" 
                wire:click="updateStatus"
                class="my-3" 
                wire:loading 
                wire:loading.target="updateStatus">
                <x-material-icon>
                    sync
                </x-material-icon>
            </x-button>
        </section>
    </x-modal>
</div>