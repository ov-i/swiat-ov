<section>
    <x-back-button :to="route('admin.posts')">
        {{ __('Back to posts list') }}
    </x-back-button>

    <form wire:submit="edit"
        wire:keydown.document.stop.ctrl.enter.throttle.1000ms="edit"
        wire:keydown.document.stop.cmd.enter.throttle.1000ms="edit">
    
        <section>
            <x-admin-card title="{{ $this->post }}" class="p-5">
                <x-slot name="actions">
                    <div class="buttons sm:flex flex-row items-center mb-3 hidden ">
                        @livewire('status-update', ['post' => $this->post], key($this->post->getKey()))
                        <x-button 
                            wire:loading.remove
                            wire:target="edit">
                            {{ __('Edit') }}
                        </x-button>
                        <x-button wire:loading.flex wire:target="edit">
                            <x-material-icon class="animate-spin">
                                sync
                            </x-material-icon>
                        </x-button>
                    </div>
                </x-slot>
                
                <x-admin-card-form wire:loading.class="opacity-50" wire:target="edit">
                    <x-slot name="formInputs">
                        <!-- Title -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-label class="uppercase" >
                                <h3>
                                    {{ __('Title') }}
                                    <span class="text-red-500 opacity-75" aria-hidden="true">*</span>
                                </h3>
                                <x-input
                                    autocomplete="off" 
                                    required 
                                    autofocus
                                    minlength="3" 
                                    maxlength="120"
                                    spellcheck="true" 
                                    wire:model.blur="postForm.title" />
                            </x-label>
    
                            @if (filled($postForm->title) && $errors->missing('postForm.title'))
                                <p class="text-sm text-gray-600">{{ $postForm->getPostPublicUri() }}</p>
                            @endif
    
                            <x-input-error for='postForm.title' />
                        </div>
    
                        <!-- Type -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-label class="uppercase" >
                                <h3>
                                    {{ __('Type') }}
                                    <span class="text-red-500 opacity-75" aria-hidden="true">*</span>
                                </h3>
                                <x-select
                                    required
                                    wire:model.live="postForm.type">
                                    <option disabled selected>{{ __('Select post type') }}</option>
        
                                    @foreach ($postForm->getPostTypesOptions() as $postType)
                                    <option 
                                        :value="$postType->value" 
                                        :selected="$this->post->getType() === $postType">
                                        {{ $postType }}
                                    </option>
                                    @endforeach
                                </x-select>
                            </x-label>
    
                            <x-input-error for='postForm.type' />
                        </div>
    
                        <!-- Excerpt -->
                        @if (!$postForm->isEvent())
                            <div class="input-group my-3 last:mb-0 first:mt-0">
                                <x-label for="excerpt" class="uppercase">
                                    <h3>
                                        {{ __('Excerpt') }}
                                        <span class="text-red-500 opacity-75" aria-hidden="true">*</span>
                                    </h3>
                                    <x-textarea 
                                        required 
                                        inputClasses="block w-full"
                                        rows="5"
                                        wire:model.live="postForm.excerpt"></x-textarea>
                                </x-label>
    
                                <x-input-error for='postForm.excerpt' />
                            </div>
                        @endif
    
                        <!-- Content -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-label for="content-form" class="uppercase" :value="__('Content')" required />
                            @if ($postForm->isEvent())
                                <x-input 
                                    name="content" 
                                    id="content-form" 
                                    inputClasses="block w-full"
                                    required 
                                    wire:model.live="postForm.content" />
                            @else
                                <x-textarea 
                                    name="content" 
                                    id="content-form" 
                                    inputClasses="block w-full" 
                                    rows="10" 
                                    required
                                    wire:model.blur="postForm.content"></x-textarea>
                            @endif
    
                            <x-input-error for='postForm.content' />
                        </div>
                    </x-slot>
    
                    <x-slot name="rightSide">
                        <!-- Category -->
                        <aside class="aside-card">
                            <x-label for="category" :value="__('Choose category')" class="uppercase" required />
    
                            <x-select 
                                name="category" 
                                id="category" 
                                required 
                                wire:model.live="postForm.category_id"
                                class="w-full mt-3">
                                <option disabled selected value="">-- {{ __('Select category') }} -- </option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->getKey() }}">{{ ucfirst($category->getName()) }}</option>
                                @endforeach
                            </x-select>
    
                            <x-input-error for='postForm.category_id' />
    
                            <button type="button"
                                class="outline-none bg-none text-cyan-500 hover:text-cyan-600 active:text-cyan-800 dark:text-white mt-3 flex items-center">
                                <span class="material-symbols-outlined text-base mr-1">
                                    add_circle
                                </span>
                                <span class="text-base">{{ __('create new category') }}</span>
                            </button>
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
        </section>
    </form>

    <section 
        class="flex items-center justify-between mt-3" 
        x-effect="if($wire.edited) setTimeout(() => $wire.edited = false, 3000)"
        x-transition.out.opacity.duration.2000ms
        x-show="$wire.edited">
        <div></div>
        <article class="flex items-center text-green-500 gap-2">   
            <x-material-icon class="border border-green-500 rounded-full p-1">
                done
            </x-material-icon>
            <p class="text-lg font-semibold">Successfully updated post</p>
        </article>
    </section>
</section>
