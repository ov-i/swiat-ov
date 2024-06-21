<section class="my-2">
    @if ($attachments->count() > 1)
        <section class="flex flex-col lg:flex-row items-start lg:items-center gap-2">
            <form wire:submit="zipAll">
                <x-button component="button" class="flex items-center gap-2 text-sm disabled:opacity-65 disabled:cursor-not-allowed">
                    <x-icon.arrow-down-tray class="text-sm" />
                    {{ __('Pobierz wszystko') }}
                    
                    <section wire:loading wire:target="zipAll">
                        <x-icon.spinner class="animate-spin" />
                    </section>
                </x-button>
            </form>
            <x-input-error for='zip'/>
        </section>
    @endif
</section>