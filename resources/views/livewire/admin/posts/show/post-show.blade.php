<section>
    <x-back-button :to="route('admin.posts')">
        {{ __('Back to posts list') }}
    </x-back-button>

    <section class="flex w-full flex-col">
        <x-flex-content actionClasses="items-center gap-2">
            <x-slot name="header">
                {{ __('Edit') }} {{ $this->post() }}
            </x-slot>

            <x-slot name="actions">
                <x-post.index.row-dropdown :$post />
            </x-slot>
        </x-flex-content>
    </section>

    <livewire:admin.posts.show.post-detail :$post />
</section>

