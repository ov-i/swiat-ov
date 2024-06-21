<section class="mt-4">
    <section class="post-show-comments">
        @auth
            <section class="my-4">
                <section class="flex items-start gap-2">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="User profile image"
                    class="h-12 w-auto object-cover rounded-full" />

                    <form wire:submit.throttle="save" class="w-full">
                        @csrf
                        <div class="flex gap-2 flex-col">
                            <div class="form-group relative w-full" x-data="{ content: '' }">
                                <x-textarea 
                                    name="content"
                                    id="content"
                                    wire:model="createComment.content"
                                    x-model="content"
                                    maxLength="120"
                                    rows="5"
                                    placeholder="{{ __('Napisz komentarz...') }}"
                                    required />

                                <div class="absolute bottom-2 right-2">
                                    <p x-text="content.length + '/120'"
                                    x-bind:class="[
                                        'inline text-gray-600 dark:text-white',
                                        content.length >= 120 ? 'text-red-500' : ''
                                        ]">
                                    </p>
                                </div>
                            </div>

                            <x-input-error for="createComment.content" />

                            <x-input-error for="too_many_request" />
                        </div>

                        <x-button component="button-info-outlined flex items-center gap-2 dark:text-zinc-300" class="p-2 mt-2">
                            <x-icon.spinner class="animate-spin" wire:loading wire:loading.target="save" />
                            <span>{{ __('Dodaj komentarz') }}</span>
                        </x-button>
                    </form>
                </section>
            </section>
        @endauth
    </section>

    <section>
        @forelse ($comments as $comment)
            <section 
                class="flex items-start gap-2 my-5 first:mt-0 last:mb-0" 
                :key="$comment->getKey()"
                x-transition>
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
                        @auth
                        <section class="self-start">
                            @can('viewAdmin')
                                <x-menu>
                                    <x-menu.button>
                                        <x-icon.ellipsis-horizontal />
                                    </x-menu.button>
                                    <x-menu.items>
                                        <x-menu.close>
                                            <x-menu.item>
                                                <x-icon.trash />
                                                Usuń
                                            </x-menu.item>
                                        </x-menu.close>
                                        <x-menu.close>
                                            <x-menu.item>
                                                <x-icon.pencil-square />
                                                Zdejmij
                                            </x-menu.item>
                                        </x-menu.close>
                                    </x-menu.items>
                                </x-menu>
                            @elseif(auth()->user()->isPostAuthor($comment->post) || $comment->user->getName() === auth()->user()->name)
                                <x-menu>
                                    <x-menu.button>
                                        <x-icon.ellipsis-horizontal />
                                    </x-menu.button>
                                    <x-menu.items>
                                        <x-menu.close>
                                            <x-menu.item>
                                                <x-icon.trash />
                                                Usuń
                                            </x-menu.item>
                                        </x-menu.close>
                                    </x-menu.items>
                                </x-menu>
                            @endcan
                        </section>
                        @endauth
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

        <x-pagination-links :resource="$comments" />
    </section>
</section>
