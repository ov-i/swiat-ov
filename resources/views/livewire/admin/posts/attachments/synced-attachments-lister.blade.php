<section>
    <ul class="inline">
        @if (filled($attachments))
            @forelse ($attachments as $attachment)
                <li class="border-b border-zinc-300 py-3 first:pt-0 last:pb-0 last:border-none"> 
                    {{ $this->getAttachmentName($attachment) }}
                </li>
            @empty
            @endforelse
        @endif
    </ul>
</section>