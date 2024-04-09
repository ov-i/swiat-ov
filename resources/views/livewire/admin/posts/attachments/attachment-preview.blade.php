<section class="attachment-preview">
    <x-material-icon class="text-[2rem]" wire:loading>
        sync
    </x-material-icon>

    <h2 class="text-sm py-2" x-show="$wire.attachments.length">
        {{ __(sprintf('Upload %d attachment(s)', count($attachments))) }}
    </h2>

    <article class="preview mt-2">
        <ul>
            @forelse ($attachments as $attachment)
                <x-dotted-list liClass="py-2 first:pt-0 last:pb-0">
                    <div class="flex w-full items-center text-center justify-between">
                        <section class="flex items-center">
                            <x-material-icon class="text-[2rem]">
                                draft
                            </x-material-icon>
                            <p>{{ $attachment->getClientOriginalName() }}</p>
                        </section>
                        <p class="px-2 first:pl-0 last:pr-0 border-r last:border-none italic">
                            size: 
                            <span>
                                {{ $this->fileSize($attachment->getSize()) }}
                            </span>
                        </p>
                    </div>
                </x-dotted-list>
            @empty
            @endforelse
        </ul>
    </article>
</section>