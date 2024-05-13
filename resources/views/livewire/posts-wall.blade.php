<section class="w-full">
    @forelse ($posts as $post)
        {{-- Single article --}}
        <x-card class="w-full my-3 first:mt-0 last:mb-0">
            <x-card.header>
                <article class="single-article">
                    <div class="thumbnail mb-5" x-show="$wire.post.thumbnail_url">
                        <img src="{{ $post->thumbnail_url }}" alt="Hero" class="w-full h-64 object-cover rounded-lg" />
                    </div>

                    <div class="flex items-start gap-2">
                        <img 
                            src="{{ $post->user->profile_photo_url }}" 
                            alt="User profle image" 
                            class="h-12 w-auto object-cover rounded-full" />

                        <p class="text-zinc-500 text-base font-secondary">
                            {{ $post->user->getName() }}

                            <span class="flex items-center text-gray-400 text-sm">
                                <x-icon.clock class="!w-4 mr-1" />
                                {{ $post->created_at->diffForHumans() }}
                            </span>
                        </p>
                    </div>

                    <div class="font-primary">
                        <a href="{{ route('posts.show', ['post' => $post]) }}">
                            <h2 class="text-2xl text-zinc-500 font-semibold mt-3 flex items-center gap-2 hover:text-zinc-600 active:text-zinc-700 border-b border-dashed border-zinc-400 transition-all duration-150 dark:text-asideMenu">
                                @if ($post->isVipOnly())
                                    <x-icon.lock-closed />
                                @endif
                                
                                {{ str($post->getTitle())->words(5) }}
                            </h2>
                        </a>

                        <p class="text-gray-500 text-base mt-3">
                            {{ str($post->getExcerpt())->words(50) }}
                        </p>

                        <div class="comments-reactions flex items-center mt-2">
                            <div class="flex items-center gap-2 mt-3">
                                <x-icon.chat-bubble-bottom-center class="w-5 h-5 text-zinc-500" />
                                <span class="text-zinc-500">{{ $post->comments()->count() }}</span>
                            </div>

                            @forelse ($post->tags()->select('name')->get() as $tag)
                                {{-- tags --}}
                                <div class="flex items-center gap-1 mt-3 ml-3 text-sm">
                                    <x-icon.tag class="w-4 h-4 text-zinc-500" />
                                    <span class="text-zinc-500">#{{ $tag->getName() }}</span>
                                </div>
                            @empty
                            @endforelse
                        </div>

                        <div class="flex justify-between">
                            <div class=""></div>
                            <a href="" class="lowercase text-sm lg:text-base text-cyan-600 mt-3 py-2">
                                {{ __('universal.keep_reding', locale: 'pl') }} &raquo;
                            </a>
                        </div>
                    </div>
                </article>
            </x-card.header>    
        </x-card>
    @empty
        <x-card>
            <x-card.header>
                <h2 class="text-2xl text-zinc-500 font-semibold mt-3 flex items-center gap-2 hover:text-zinc-600 active:text-zinc-700 border-b border-dashed border-zinc-400 transition-all duration-150 dark:text-asideMenu">
                    <x-icon.lock-closed />
                    {{ __('universal.no_posts', locale: 'pl') }}
                </h2>
            </x-card.header>
        </x-card>
    @endforelse

    {{-- pagination --}}
    <x-pagination-links :resource="$posts" />
</section>