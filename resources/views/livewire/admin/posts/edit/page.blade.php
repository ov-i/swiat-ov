<section>
    <x-back-button :to="route('admin.posts')">
        {{ __('Back to posts list') }}
    </x-back-button>

    <livewire:admin.posts.edit.form :$post />
</section>
