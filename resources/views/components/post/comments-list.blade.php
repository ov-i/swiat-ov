@props(['post'])

<section>
    @forelse ($post->comments as $comment)
        <section class="flex items-start gap-2 my-5 first:mt-0 last:mb-0">
            <img src="{{ $comment->user->profile_photo_url }}" alt="User profile image" class="h-12 w-auto object-cover rounded-full" />

            <section class="bg-white rounded shadow p-4 w-full">
                <section class="flex items-center justify-between">
                    <section class="profile-info">
                        <p class="text-zinc-500 text-base font-secondary">
                            {{ $comment->user->getName() }}

                            <span class="flex items-center text-gray-400 text-sm">
                                <x-icon.clock class="!w-4 mr-1" />

                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </p>

                        <p class="text-base text-zinc-600 font-primary mt-2">
                            {{ $comment->content }}
                        </p>

                        <section class="flex items-center gap-2 mt-2">
                            <x-icon.heart class="w-5 h-5" />

                            <p class="text-sm text-zinc-600 font-secondary">
                                0
                            </p>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    @empty
        <section class="bg-white rounded shadow p-4">
            <p class="text-zinc-500 text-base font-secondary">
                {{ __('Brak komentarzy') }}
            </p>
        </section>
    @endforelse

    <x-pagination-links 
        :resource="$post->comments()->paginate(\App\Enums\ItemsPerPage::Default->value)" />
</section>