<section>
    <x-admin-card title="" class="mt-2 w-full overflow-x-auto">
        <div class="user-details w-full">
            <x-resource-detail property='id' :value="$user->getKey()" />
            <x-resource-detail property='name' :value="$user->getName()" />
            <x-resource-detail property='email' :value="$user->getEmail()" isLink="true" to="mailto: {{ $user->getEmail() }}"/>
            <x-resource-detail property='verified at' :value="$user->email_verified_at" />
            <x-resource-detail property='preferred theme' :value="$user->getTheme()" />
            <x-resource-detail property='status' help="Current user account status (active / banned)">
                <x-slot name="value">
                    <x-fields.boolean-field condition="{{ !$user->isBlocked() }}" />
                </x-slot>
            </x-resource-detail>
            <x-resource-detail property='verified' help="Is email address verified">
                <x-slot name="value">
                    <x-fields.boolean-field condition="{{ $user->hasVerifiedEmail() }}" />
                </x-slot>
            </x-resource-detail>
            <x-resource-detail property='created at' :value="$user->created_at" />
            <x-resource-detail property='deleted at' :value="$user->deleted_at" />
        </div>
    </x-admin-card>

    <section class="relations">
        {{-- Attachments --}}
        {{-- <livewire:admin.users.show.relations.attachments :$user /> --}}

        {{-- Tags --}}
        {{-- <livewire:admin.users.show.relations.tags :$user /> --}}
    </section>
</section>
