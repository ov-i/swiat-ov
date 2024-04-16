@php
    use Illuminate\Support\Str;
@endphp

<section>
    <x-back-button :to="route('admin.posts')">
        {{ __('Back to posts list') }}
    </x-back-button>

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
                            <x-material-icon classes="animate-spin">
                                sync
                            </x-material-icon>
                        </x-button>
                    </div>
                </x-slot>
    
                <x-admin-card-form>
                    <x-slot name="formInputs">
                        <!-- Title -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-label class="uppercase">
                                <x-slot:value>
                                    <h3>
                                        Title
                                        <span class="text-red-500 opacity-75" aria-hidden="true">*</span>
                                    </h3>
                                    <x-input type="text"
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
                                        wire:loading.class="read-only:cursor-not-allowed  read-only:bg-gray-200 read-only:opacity-85"/>
                                </x-slot:value>
                            </x-label>
    
                            @if(filled($postForm->title) && $errors->missing('postForm.title'))
                                <p class="text-sm text-gray-600">
                                    {{ $postForm->getPostPublicUri() }}
                                </p>
                            @endif
    
                            <x-input-error for='postForm.title' />
                        </div>
    
                        <!-- Type -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-label class="uppercase">
                                <x-slot:value>
                                    <h3>
                                        {{ __('Type') }}
                                        <span class="text-red-500 opacity-75" aria-hidden="true">*</span>
                                    </h3>
                                    <x-select
                                        name="type"
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
                                    </x-select>
                                </x-slot:value>
                            </x-label>
    
                            <x-input-error for='postForm.type' />
                        </div>
    
                        <!-- Excerpt -->
                        @if (!$postForm->isEvent())
                            <div class="input-group my-3 last:mb-0 first:mt-0">
                                <section class="relative">
                                    <x-label class="uppercase">
                                        <x-slot:value>
                                            <h3>
                                                {{ __('Excerpt') }}
                                                <span class="text-red-500 opacity-75" aria-hidden="true">*</span>
                                            </h3>
                                            
                                            <x-textarea 
                                                required 
                                                rows="5"
                                                wire:target="save" 
                                                wire:loading.class="read-only:cursor-not-allowed  read-only:bg-gray-200 read-only:opacity-85"
                                                minLength="50"
                                                maxLength="255"
                                                errorTarget='postForm.excerpt'
                                                wire:model.live="postForm.excerpt"></x-textarea>

                                            <div class="absolute bottom-2 right-2">
                                                <p 
                                                    x-text="$wire.postForm.excerpt.length + '/255'"
                                                    @class([
                                                        'inline text-gray-600 dark:text-white',
                                                        'text-red-500' => str($postForm->excerpt)->length() >= 255
                                                    ])>
                                                </p>
                                            </div>

                                        </x-slot:value>
                                    </x-label>
                                </section>
    
                                <x-input-error for='postForm.excerpt' />
                            </div>
                        @endif
    
                        <!-- Content -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-label for="content-form" class="uppercase" :value="__('Content')" required />
                            @if ($postForm->isEvent())
                                <x-input
                                    full
                                    required 
                                    errorTarget='postForm.content'
                                    wire:target="save" 
                                    wire:loading.class="read-only:cursor-not-allowed  read-only:bg-gray-200 read-only:opacity-85"
                                    wire:model.blur="postForm.content" />
                            @else
                                <x-textarea 
                                    rows="10" 
                                    errorTarget='postForm.content'
                                    wire:target="save" 
                                    wire:loading.class="read-only:cursor-not-allowed  read-only:bg-gray-200 read-only:opacity-85"
                                    required
                                    wire:model.blur="postForm.content"></x-textarea>
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
                                        {{ 
                                            count($postForm->attachments) ? 
                                                'Toggle Attachments' : 
                                                'Add Attachments' 
                                        }}
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
                            <x-label for="category" :value="__('Choose category')" class="uppercase" required />
    
                            <x-select name="category" id="category" required wire:model="postForm.category_id"
                                class="w-full mt-3">
                                <option readonly selected value="">{{ __('Select category') }}</option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->getKey() }}">{{ ucfirst($category->getName()) }}</option>
                                @endforeach
                            </x-select>
    
                            <x-input-error for='postForm.category_id' />
    
                            @if (auth()->user()->can('write-category'))
                                <button type="button"
                                    class="outline-none bg-none text-cyan-500 hover:text-cyan-600 active:text-cyan-800 dark:text-white mt-3 flex items-center" wire:click="openModal()" >
                                    <span class="material-symbols-outlined text-base mr-1">
                                        add_circle
                                    </span>
                                    <span class="text-base">{{ __('create new category') }}</span>
                                </button>

                                <livewire:admin.posts.category-create wire:model="modalOpen" />
                            @endif
                        </aside>
    
                        <!-- Tags -->
                        <aside class="aside-card">
                            <x-label 
                                for="tags" 
                                :value="__('Select tags')" 
                                class="text-md pt-0 mt-0 uppercase text-gray-600" />
    
                            <x-select
                                name="tags" 
                                id="tags" 
                                wire:model.throttle.live="postForm.tags"
                                inputClasses="w-full mt-3" 
                                multiple
                            >
                                @forelse ($tags as $tag)
                                    <option value="{{ $tag->getKey() }}">{{ ucfirst($tag->getName()) }}</option>
                                @endforeach
                            </x-select>
    
                            <x-input-error for='postForm.tags' />
                        </aside>
    
                        <!-- Thumbnail -->
                        @if (!$postForm->isEvent())
                            <aside class="aside-card">
                                <div class="thumbnail-url">
                                    <x-label 
                                        for="thumbnail_url" 
                                        :value="__('Select thumbnail')" 
                                        class="text-md pt-0 mt-0 uppercase text-gray-600" />
    
                                    <x-input 
                                        type="file" 
                                        name="thumbnail_url" 
                                        id="thumbnail_url" 
                                        inputClasses="from-control mt-3 shadow-none"
                                        accept="image/png, image/jpgeg, image/svg, image/tiff, image/bmp"
                                        wire:model="postForm.thumbnailPath" />
    
                                    @error('postForm.thumbnailPath')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </aside>
                        @endif
    
                        <!-- Publishable date time -->
                        @if (!$this->cantBePublished())
                            <aside class="aside-card">
                                <div class="publishable-date">
                                    <x-label 
                                        for="publishableDateTime" 
                                        :value="__('Delay')" 
                                        class="text-md pt-0 mt-0 uppercase text-gray-600" />
    
                                    <x-input 
                                        type="datetime-local" 
                                        name="publishableDateTime" 
                                        id="publishableDateTime"
                                        inputClasses="from-control mt-3" 
                                        wire:model="postForm.should_be_published_at" />
    
                                    <x-input-error for='postForm.should_be_published_at' />
                                    @error('postForm.should_be_published_at')
                                        <span class="text-red-600 text-sm block">{{ $message }}</span>
                                    @enderror
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
                        <x-material-icon classes="animate-spin">
                            sync
                        </x-material-icon>
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