<section>
    <x-back-button :to="route('admin.posts')">
        {{ __('Back to posts list') }}
    </x-back-button>

    <form wire:submit="edit"
        wire:keydown.document.stop.ctrl.enter.throttle.1000ms="edit"
        wire:keydown.document.stop.cmd.enter.throttle.1000ms="edit">
    
        <section>
            <x-admin-card title="{{ $this->post() }}">
                <x-slot name="actions">
                    <div class="buttons sm:flex flex-row items-center mb-3 hidden ">
                        @livewire('status-update', ['post' => $this->post()], key($this->post()->getKey()))
                        <x-button 
                            type="button" 
                            :disabled="$this->isFormUnTouched()">
                            {{ $this->isFormUnTouched() ? __('Form untouched') : __('Edit') }}
                        </x-button>
                        <x-button wire:loading wire:target="edit">
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
                                wire:model.blur="updatePostForm.title" />
    
                            @if (filled($this->updatePostForm->title))
                                <p class="text-sm text-gray-600">{{ $this->getPostPublicUri() }}</p>
                            @endif
    
                            <x-input-error for='updatePostForm.title' />
                        </div>
    
                        <!-- Type -->
                        <div class="input-group my-3 last:mb-0 first:mt-0">
                            <x-label for="type" class="uppercase" :value="__('Type')" required />
                            <x-select
                                name="type"
                                id="type" 
                                inputClasses="w-full block" 
                                required
                                wire:model.live="updatePostForm.type">
                                <option readonly selected value="" class="text-gray-100">
                                    -- {{ __('Select post type') }} --
                                </option>
    
                                @foreach (\App\Enums\Post\PostTypeEnum::cases() as $postType)
                                <option value="{{ $postType }}"
                                    {{ $this->post()->getType() === $postType->value ? 'selected' : null }}>
                                    {{ ucfirst($postType->value) }}
                                </option>
                            @endforeach
                            </x-select>
    
                            <x-input-error for='updatePostForm.type' />
                        </div>
    
                        <!-- Excerpt -->
                        @if (!$this->isEvent())
                            <div class="input-group my-3 last:mb-0 first:mt-0">
                                <x-label for="excerpt" class="uppercase" :value="__('Excerpt')" required />
                                <x-textarea 
                                    name="excerpt" 
                                    id="excerpt" 
                                    required 
                                    inputClasses="block w-full"
                                    rows="5"
                                    wire:model.blur="updatePostForm.excerpt"></x-textarea>
    
                                <x-input-error for='updatePostForm.excerpt' />
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
                                    wire:model.blur="updatePostForm.content" />
                            @else
                                <x-textarea 
                                    name="content" 
                                    id="content-form" 
                                    inputClasses="block w-full" 
                                    rows="10" 
                                    required
                                    wire:model.blur="updatePostForm.content"></x-textarea>
                            @endif
    
                            <x-input-error for='updatePostForm.content' />
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
                                wire:model="updatePostForm.category_id"
                                class="w-full mt-3">
                                <option readonly selected value="">-- {{ __('Select category') }} -- </option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->getKey() }}">{{ ucfirst($category->getName()) }}</option>
                                @endforeach
                            </x-select>
    
                            <x-input-error for='updatePostForm.categoryId' />
    
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
                                wire:model.throttle.live="updatePostForm.tags"
                                inputClasses="w-full mt-3" 
                                multiple
                            >
                                @forelse ($tags as $tag)
                                    <option value="{{ $tag->getKey() }}">{{ ucfirst($tag->getName()) }}</option>
                                @endforeach
                            </x-select>
    
                            <x-input-error for='updatePostForm.tags' />
                        </aside>
                    </x-slot>
                </x-admin-card-form>
                
                <div class="buttons flex flex-row w-full items-center mt-6 sm:hidden">
                    <x-button 
                        type="button" 
                        class="disabled:cursor-not-allowed disabled:bg-transparent disabled:text-gray-400 disabled:hover:border-gray-200 hover:border-initial" 
                        :disabled="$this->isFormUnTouched()">
                        {{ $this->isFormUnTouched() ? __('Form untouched') : __('Edit') }}
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
</section>
