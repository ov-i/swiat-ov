<section>
    <x-back-button :to="route('admin.users')">
        {{ __('Back to users list') }}
    </x-back-button>

    <section class="flex w-full flex-col">
        <x-flex-content actionClasses="items-center gap-2">
            <x-slot name="header">
                {{ __('Edit') }} {{ $this->user() }}
            </x-slot>

            <x-slot name="actions">
                <livewire:admin.users.user-lock :$user />
                <x-user.index.row-dropdown :$user />
            </x-slot>
        </x-flex-content>
    </section>

    <livewire:admin.users.show.user-detail :$user />
</section>

