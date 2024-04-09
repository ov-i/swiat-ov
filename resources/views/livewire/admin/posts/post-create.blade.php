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
                    <div class="buttons sm:flex flex-row items-center mb-3 hidden ">
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
                            <x-label for="title" :value="__('Title')" class="uppercase" required />
                            <x-input type="text" 
                                name="title" 
                                autocomplete="off" 
                                id='title' 
                                inputClasses="block w-full"
                                required 
                                autofocus
                                minlength="3" 
                                maxlength="120"
                                spellcheck="true" 
                                wire:model.blur="createPostForm.title" />
    
                            @if (filled($this->createPostForm->title))
                                <p class="text-sm text-gray-600">{{ $this->getPostPublicUri() }}</p>
                            @endif
    
                            <x-input-error for='createPostForm.title' />
                        </div>
    
                        <!-- Type -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-label for="type" class="uppercase" :value="__('Type')" required />
                            <x-select
                                name="type"
                                id="type" 
                                inputClasses="w-full block" 
                                required
                                wire:model.live="createPostForm.type">
                                <option readonly selected value="" class="text-gray-100">
                                    -- {{ __('Select post type') }} --
                                </option>
                                @foreach ($this->getPostTypesOptions as $postType)
                                    <option value="{{ $postType }}">{{ ucfirst($postType->value) }}</option>
                                @endforeach
                            </x-select>
    
                            <x-input-error for='createPostForm.type' />
                        </div>
    
                        <!-- Excerpt -->
                        @if (!$this->isEvent())
                            <div class="input-group my-3 last:mb-0 first:mt-0">
                                <x-label for="excerpt" class="uppercase" :value="__('Excerpt')" required />
                                <section class="relative">
                                    <x-textarea 
                                    name="excerpt" 
                                    id="excerpt" 
                                    required 
                                    inputClasses="block w-full"
                                    rows="5"
                                    minLength="50"
                                    maxLength="255"
                                    wire:model.live="createPostForm.excerpt"></x-textarea>

                                    <div class="absolute bottom-2 right-2">
                                        <p class="inline text-gray-600 dark:text-white {{ Str::length($createPostForm->excerpt) >= 255 ? 'text-red-500' : null }}">
                                            {{ Str::length($createPostForm->excerpt) }}/255
                                        </p>
                                    </div>
                                </section>
    
                                <x-input-error for='createPostForm.excerpt' />
                            </div>
                        @endif
    
                        <!-- Content -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-label for="content-form" class="uppercase" :value="__('Content')" required />
                            @if ($this->isEvent())
                                <x-input 
                                    name="content" 
                                    id="content-form" 
                                    inputClasses="block w-full"
                                    required 
                                    wire:model.blur="createPostForm.content" />
                            @else
                                <x-textarea 
                                    name="content" 
                                    id="content-form" 
                                    inputClasses="block w-full" 
                                    rows="10" 
                                    required
                                    wire:model.blur="createPostForm.content"></x-textarea>
                            @endif
    
                            <x-input-error for='createPostForm.content' />
                        </div>
                    </x-slot>
    
                    <x-slot name="underInputs">
                        <!-- Attachments -->
                        @if (!$this->isEvent())
                            <section class="attachments">
                                <div class="w-full pt-3 pb-5 mt-3 border-b border-gray-200 dark:border-gray-700 xl:border-none">
                                    <x-button type="button" component="button-zinc-outlined" wire:click="attachmentsModal = true">
                                        {{ 
                                            count($createPostForm->attachments) ? 
                                                'Toggle Attachments' : 
                                                'Add Attachments' 
                                        }}
                                    </x-button>

                                    <livewire:admin.posts.sync-attachments-modal wire:model="attachmentsModal" />

                                    <x-input-error for='createPostForm.attachments.*' />
                                </div>
                            </section>

                            <livewire:admin.posts.attachments.synced-attachments-lister 
                                wire:attachments.live="$createPostForm.attachments" />
                        @endif
                    </x-slot>
    
                    <x-slot name="rightSide">
                        <!-- Category -->
                        <aside class="aside-card">
                            <x-label for="category" :value="__('Choose category')" class="uppercase" required />
    
                            <x-select name="category" id="category" required wire:model="createPostForm.categoryId"
                                class="w-full mt-3">
                                <option readonly selected value="">-- {{ __('Select category') }} -- </option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->getKey() }}">{{ ucfirst($category->getName()) }}</option>
                                @endforeach
                            </x-select>
    
                            <x-input-error for='createPostForm.categoryId' />
    
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
                                wire:model.throttle.live="createPostForm.tags"
                                inputClasses="w-full mt-3" 
                                multiple
                            >
                                @forelse ($tags as $tag)
                                    <option value="{{ $tag->getKey() }}">{{ ucfirst($tag->getName()) }}</option>
                                @endforeach
                            </x-select>
    
                            <x-input-error for='createPostForm.tags' />
                        </aside>
    
                        <!-- Thumbnail -->
                        @if (!$this->isEvent())
                            <!-- @TODO: Thumbnail should be selected by attachments tab. -->
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
                                        wire:model="createPostForm.thumbnailPath" />
    
                                    @error('createPostForm.thumbnailPath')
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
                                        wire:model="createPostForm.publishableDateTime" />
    
                                    <x-input-error for='createPostForm.publishableDateTime' />
                                    @error('createPostForm.publishableDateTime')
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