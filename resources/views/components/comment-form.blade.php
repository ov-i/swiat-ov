<section class="post-show-comments">
  @auth
      <section class="my-4">
          <section class="flex items-start gap-2">
              <img src="{{ auth()->user()->profile_photo_url }}" alt="User profile image"
                  class="h-12 w-auto object-cover rounded-full" />

              <form
                  method="POST" 
                  class="w-full"
                  {{ $attributes }}>
                  @csrf

                  <div class="flex gap-2 flex-col">
                      <div class="form-group relative" x-data="{ content: '' }">
                          <x-textarea 
                              name="content" 
                              id="content"
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
                  </div>

                  <x-button component="button-info-outlined dark:text-zinc-300" class="p-2 mt-2">
                      {{ __('Dodaj komentarz') }}
                  </x-button>
              </form>
          </section>
      </section>
  @endauth
</section>