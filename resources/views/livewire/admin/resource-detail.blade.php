<section>
    <x-back-button :to="$this->generateListLink()">
        {{ __(sprintf('Back to %s list', $this->resourceNamePlural() )) }}
    </x-back-button>

    <section class="flex w-full flex-col">
        <x-flex-content actionClasses="items-center gap-2">
            <x-slot name="header">
                {{ __('Edit') }} {{ $this->resource() }}
            </x-slot>

            <x-slot name="actions">
                <x-iconed-link 
                :link="$this->generateEditLink()"
                icon="edit" 
                icon_size="[2rem]"
                classes="button" />

                <x-button type="button" component="button" wire:click="resource.delete()">
                    <x-material-icon class="text-[2rem]">
                        delete
                    </x-material-icon>
                </x-button>

                @if (method_exists($this->resource(), 'trashed') && $this->resource()->trashed())
                    <x-button type="button" component="button">
                        <x-material-icon>
                            history
                        </x-material-icon>
                    </x-button>
                @endif
            </x-slot>
        </x-flex-content>
    </section>
</section>