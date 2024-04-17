<form wire:submit="edit"
    wire:keydown.document.stop.ctrl.enter.throttle.1000ms="edit"
    wire:keydown.document.stop.cmd.enter.throttle.1000ms="edit">

  <x-admin-card title="{{ $this->post }}" class="p-5">

    <x-slot name="actions">
        <div class="buttons sm:flex flex-row items-center mb-3 hidden ">
            <livewire:status-update :$post :key="$post->getKey()" />

            <x-button 
                wire:loading.remove
                wire:target="edit">
                {{ __('Edit') }}
            </x-button>
            <x-button wire:loading.flex wire:target="edit">
                <x-icon.spinner />
            </x-button>
        </div>
    </x-slot>

    <x-admin-card-form wire:loading.class="opacity-50" wire:target="edit">
      <x-slot name="formInputs">

          <!-- Title -->
          <div class="input-group my-3 last:mb-0 first:mt-0">
              <x-fields.labelled-input 
                autocomplete="off"
                autofocus
                minLength="3"
                maxLength="120"
                spellcheck="true"
                wire:model.blur="postForm.title"
                for="Title" 
                required 
                full />

              @if (filled($postForm->title) && $errors->missing('postForm.title'))
                  <p class="text-sm text-gray-600">{{ $postForm->getPostPublicUri() }}</p>
              @endif

              <x-input-error for='postForm.title' />
          </div>

          <!-- Type -->
          <div class="input-group my-3 last:mb-0 first:mt-0">
            <x-fields.labelled-select for='Type' required wire:model.live="postForm.type">
              <option disabled selected>{{ __('Select post type') }}</option>

              @foreach ($postForm->getPostTypesOptions() as $postType)
                <option 
                    value="{{ $postType->value }}" 
                    selected="{{ $post->getType() === $postType }}">
                    {{ $postType }}
                </option>
              @endforeach
            </x-fields.labelled-select>

            <x-input-error for='postForm.type' />
          </div>

          <!-- Excerpt -->
          @if (!$postForm->isEvent())
              <div class="input-group my-3 last:mb-0 first:mt-0">
                <x-fields.labelled-textarea for='excerpt' wire:model.live="postForm.excerpt" full required rows="5" />

                <x-input-error for='postForm.excerpt' />
              </div>
          @endif

          <!-- Content -->
          <div class="input-group my-3 last:mb-0 first:mt-0">
              @if ($postForm->isEvent())
                <x-fields.labelled-input 
                  wire:model.blur="postForm.content"
                  for="Content" 
                  required 
                  full />
              @else
                <x-fields.labelled-textarea for='content' wire:model.blur="postForm.content" rows="10" full required />
              @endif

              <x-input-error for='postForm.content' />
          </div>
      </x-slot>

      <x-slot name="rightSide">

          <!-- Category -->
          <aside class="aside-card">
            <x-fields.labelled-select for='category' wire:model.live="postForm.categoryId" full required>
              <option disabled selected value="">-- {{ __('Select category') }} -- </option>

              @foreach ($categories as $category)
                <option value="{{ $category->getKey() }}">{{ ucfirst($category->getName()) }}</option>
              @endforeach
            </x-fields.labelled-select>

            <x-input-error for='postForm.category_id' />

            <x-button component="button" type="button"
              class="text-cyan-500 hover:text-cyan-600 active:text-cyan-800 dark:text-white mt-3 flex items-center">
                <x-icon.add />
              <span class="text-base">{{ __('create new category') }}</span>
            </x-button>
          </aside>

          <!-- Tags -->
          <aside class="aside-card">
            <x-fields.labelled-select for='tags' wire:model.live="postForm.tags" full multiple>
              @forelse ($tags as $tag)
                <option value="{{ $tag->getKey() }}">{{ str($tag->getName())->ucfirst() }}</option>
              @empty
                <option value="" disabled>{{ __('No tags found') }}</option>
              @endforelse
            </x-fields.labelled-select>

            <x-input-error for='postForm.tags' />
          </aside>

      </x-slot>
    </x-admin-card-form>

    <div class="buttons flex flex-row w-full items-center mt-6 sm:hidden">
      <x-button 
          wire:loading.remove
          wire:target="edit">
          {{ __('Edit') }}
      </x-button>
      <x-button wire:loading wire:target="edit">
          <x-material-icon classes="animate-spin">
              sync
          </x-material-icon>
      </x-button>
    </div>
  </x-admin-card>

  <x-fadeable-message property="$wire.edited" :message="__('Post updated successfully')" class="mt-3" />
</form>