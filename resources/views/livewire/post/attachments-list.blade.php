<div>
    @forelse ($attachments as $attachment)
        <section class="flex items-center gap-2 my-3 first:mt-0 last:mb-0" :key="$attachment->getKey()">
            <livewire:post.download-attachment-button :$attachment />
    
            <p class="text-sm text-zinc-600 font-secondary">
                <a href="{{ $attachment->getPublicUrl() }}"
                    class="text-blue-500 hover:underline">
                    {{ $attachment->getOriginalName() }}
                </a>
            </p>
        </section>
    @empty
    @endforelse
</div>