<section id="page-section">
    <x-back-button :to="route('admin.dashboard')">
        {{ __('Back to dashboard') }}
    </x-back-button>

    <x-admin-card title="Posts">
        <x-slot:actions>
            <x-post.index.fields.create-button>
                {{ __('Add new') }}
            </x-post.index.fields.create-button>
        </x-slot:actions>
        
        <section class="py-4 border-b border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-secondary font-semibold text-gray-600 dark:text-zinc-300">
                {{ __('Search & Filters') }}
            </h3>
        </section>

        <livewire:admin.posts.index.table />
    </x-admin-card>
</section>
