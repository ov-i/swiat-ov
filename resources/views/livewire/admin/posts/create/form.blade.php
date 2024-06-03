<section>
    <form wire:submit="save" 
        wire:keydown.document.stop.ctrl.enter.throttle.1000ms="save"
        wire:keydown.document.stop.cmd.enter.throttle.1000ms="save">
        <section>
            <x-admin-card :title="__('Create Post')">

                <x-slot name="actions">
                    <div class="buttons sm:flex flex-row items-center mb-3 hidden">
                        <x-button 
                            type="button"
                            component="button-zinc-outlined mr-3" 
                            wire:click.confirm="resetForm">
                            {{ __('Reset form') }}
                        </x-button>
                        <x-button 
                            type="submit" 
                            wire:loading.remove
                            wire:target="save">
                            {{ __($this->getSaveButtonState()) }}
                        </x-button>
                        <x-button wire:loading wire:target="save">
                            <x-icon.spinner />
                        </x-button>
                    </div>
                </x-slot>
    
                <x-admin-card-form>
                    <x-slot name="formInputs">

                        <!-- Title -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-fields.labelled-input 
                                for='title'
                                full 
                                autocomplete="off"
                                errorTarget="postForm.title"
                                required 
                                autofocus
                                minlength="3" 
                                maxlength="120"
                                spellcheck="true" 
                                wire:model.blur="postForm.title"
                                wire:target="save" 
                                wire:loading.class="read-only:cursor-not-allowed  read-only:bg-gray-200 read-only:opacity-85" />
    
                            @if(filled($postForm->title) && $errors->missing('postForm.title'))
                                <p class="text-sm text-gray-600">
                                    {{ $postForm->getPostPublicUri() }}
                                </p>
                            @endif
    
                            <x-input-error for='postForm.title' />
                        </div>
    
                        <!-- Type -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-fields.labelled-select 
                                for='type'
                                required
                                errorTarget='postForm.type'
                                wire:target="save" 
                                wire:loading.class="read-only:cursor-not-allowed  read-only:bg-gray-200 read-only:opacity-85"
                                wire:model.live="postForm.type">
                                    <option disabled selected class="text-gray-100">
                                        {{ __('Select post type') }}
                                    </option>
                                    @foreach ($postForm->getPostTypesOptions() as $postType)
                                        <option value="{{ $postType->value }}">
                                            {{ $postType->label() }}
                                        </option>
                                    @endforeach
                            </x-fields.labelled-select>
    
                            <x-input-error for='postForm.type' />
                        </div>
    
                        <!-- Excerpt -->
                        @if (!$postForm->isEvent())
                            <div class="input-group my-3 last:mb-0 first:mt-0">
                                <section class="relative">
                                    <x-fields.labelled-textarea
                                        for='excerpt'
                                        required 
                                        rows="5"
                                        wire:target="save" 
                                        wire:loading.class="read-only:cursor-not-allowed  read-only:bg-gray-200 read-only:opacity-85"
                                        minLength="50"
                                        maxLength="255"
                                        errorTarget='postForm.excerpt'
                                        wire:model.live="postForm.excerpt" />

                                    <div class="absolute bottom-2 right-2">
                                        <p 
                                            x-text="$wire.postForm.excerpt.length + '/255'"
                                            @class([
                                                'inline text-gray-600 dark:text-white',
                                                'text-red-500' => str($postForm->excerpt)->length() >= 255
                                            ])>
                                        </p>
                                    </div>
                                </section>
    
                                <x-input-error for='postForm.excerpt' />
                            </div>
                        @endif
    
                        <!-- Content -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            @if ($postForm->isEvent())
                                <x-fields.labelled-input
                                    for='content'
                                    full
                                    required 
                                    errorTarget='postForm.content'
                                    wire:target="save" 
                                    wire:loading.class="read-only:cursor-not-allowed  read-only:bg-gray-200 read-only:opacity-85"
                                    wire:model.blur="postForm.content" />
                            @else
                                <x-fields.labelled-textarea 
                                    for='content'
                                    rows="10" 
                                    errorTarget='postForm.content'
                                    wire:target="save" 
                                    wire:loading.class="read-only:cursor-not-allowed  read-only:bg-gray-200 read-only:opacity-85"
                                    required
                                    wire:model.blur="postForm.content"></x-fields.labelled-textarea>
                            @endif
    
                            <x-input-error for='postForm.content' />
                        </div>
                    </x-slot>
    
                    <x-slot name="underInputs">
                        <!-- Attachments -->
                        @if (!$postForm->isEvent() && auth()->user()->can('post-sync-attachments'))
                            <section class="attachments">
                                <div class="w-full pt-3 pb-5 mt-3 border-b border-gray-200 dark:border-gray-700 xl:border-none">
                                    <x-button type="button" component="button-zinc-outlined" wire:click="attachmentsModal = true">
                                        Attachments
                                    </x-button>

                                    <livewire:admin.posts.sync-attachments-modal wire:model="attachmentsModal" />

                                    <x-input-error for='postForm.attachments.*' />
                                </div>
                            </section>

                            <livewire:admin.posts.attachments.synced-attachments-lister 
                                wire:attachments.live="$postForm.attachments" 
                                x-show="postForm.attachments.length" />
                        @endif
                    </x-slot>
    
                    <x-slot name="rightSide">

                        <!-- Category -->
                        <aside class="aside-card">
                            <x-fields.labelled-select for='category' full required wire:model="postForm.category_id">
                                <option readonly selected value="">{{ __('Select category') }}</option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->getKey() }}">
                                        {{ str($category->getName())->ucfirst() }}
                                    </option>
                                @empty
                                @endforelse
                            </x-fields.labelled-select>

                            <x-input-error for='postForm.category_id' />
    
                            @can('write-category')
                                <x-button type="button" component="button"
                                    class="outline-none bg-none text-cyan-500 hover:text-cyan-600 active:text-cyan-800 dark:text-white mt-3 flex items-center" wire:click="openModal()" >
                                    
                                    <x-icon.add />
                                    <span class="text-base">{{ __('create new category') }}</span>
                                </x-button>

                                <livewire:admin.posts.category-create wire:model="modalOpen" />
                            @endcan
                        </aside>
    
                        <!-- Tags -->
                        <aside class="aside-card">
                            <x-fields.labelled-select for='tags' full multiple wire:model.live="postForm.tags">
                                @forelse ($tags as $tag)
                                    <option value="{{ $tag->getKey() }}">{{ ucfirst($tag->getName()) }}</option>
                                @empty
                                    <option value="" disabled>{{ __('No tags found') }}</option>
                                @endforelse
                            </x-fields.labelled-select>
    
                            <x-input-error for='postForm.tags' />
                        </aside>
    
                        <!-- Thumbnail -->
                        @if (!$postForm->isEvent())
                            <aside class="aside-card">
                                <div class="thumbnail-url">
                                    <h3 class="font-secondary">{{ __('Adding thumbnail is currently unavailable.') }}</h3>
                                    <p class="font-secondary text-sm">{{ __('Post will use a Unsplash.it service instead.') }}</p>
                                </div>
                            </aside>
                        @endif
    
                        <!-- Scheduled date -->
                        @if (!$this->cantBePublished())
                            <aside class="aside-card">
                                <div class="publishable-date">
                                    <x-fields.labelled-input 
                                        full
                                        for='scheduled at'
                                        type="datetime-local" 
                                        wire:model="postForm.scheduled_publish_date" />
    
                                    <x-input-error for='postForm.scheduled_publish_date' />
                                </div>
                            </aside>
                        @endif
                    </x-slot>
                </x-admin-card-form>
    
                <div class="buttons flex flex-row w-full items-center mt-6 sm:hidden">
                    <x-button 
                        type="button"
                        component="button-zinc-outlined mr-3" 
                        wire:click.confirm="resetForm">
                        {{ __('Reset form') }}
                    </x-button>
                    <x-button 
                        type="submit" 
                        wire:loading.remove
                        wire:target="save">
                        {{ __($this->getSaveButtonState()) }}
                    </x-button>
                    <x-button wire:loading wire:target="save">
                        <x-icon.spinner />
                    </x-button>
                </div>
            </x-admin-card>
        </section>
    </form>
</section>

@script
<script>
    Livewire.on('category-added', function() {
        $wire.closeModal()
        $wire.$refresh()
    })
</script>
@endscript