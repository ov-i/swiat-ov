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
                                errorTarget="too_many_request"
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