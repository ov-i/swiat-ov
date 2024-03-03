<form wire:submit="save">
    <section class="wrapper-heading flex flex-row items-center justify-between w-2/3 mb-3 font-primary">
        <article class="wrapper-header mb-3">
            <h1 class="font-secondary text-2xl">{{ __('Create Post') }}</h1>
            @if(filled($this->createPostForm->title))
                <p class="text-sm text-gray-600">{{ $this->getPostPublicUri() }}</p>
            @endif
        </article>
        <article class="cta flex flex-row justify-right items-center">
            <button class="button-outlined mr-3" wire:click.confirm="resetForm">{{ __('Reset form') }}</button>
            <button class="button-info-outlined" type="submit">
                {{ $this->canBePublished() ? __('Publish') : __('Create') }}
            </button>
        </article>
    </section>
    <div class="wrapper-main flex flex-row items-start justify-between font-secondary">
        <section class="left-side-wrapper w-2/3">
            <section class="left-side w-full bg-white border-1 border-gray-300 rounded shadow-md p-3">
                <!-- Title -->
                <div class="input-group my-3 last:mb-0 first:mt-0">
                    <label for="title" class="uppercase">{{ __('Title') }}<i class="text-red-500">*</i></label>
                    <input 
                        type="text" 
                        name="title" 
                        class="border-1 rounded border-gray-300 w-full block" 
                        autocomplete="off" 
                        id='title' 
                        required 
                        autofocus
                        minlength="3"
                        maxlength="120"
                        spellcheck="true"
                        wire:model.blur="createPostForm.title"
                    />

                    @error('createPostForm.title') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                
                <!-- Type -->
                <div class="input-group my-3 last:mb-0 first:mt-0">
                    <label for="type" class="uppercase">
                        {{ __('Type') }}
                        <i class="text-red-500">*</i>
                    </label>
                    <select 
                        name="type" 
                        id="type" 
                        class="border-1 rounded border-gray-300 w-full block"
                        required
                        wire:model.live="createPostForm.type"
                    >
                        <option readonly selected value="" class="text-gray-100">
                            -- {{ __('Select post type') }} --
                        </option>
                        @foreach ($this->getPostTypesOptions as $postType)
                            <option value="{{ $postType }}">{{ ucfirst($postType->value) }}</option>
                        @endforeach
                    </select>

                    @error('createPostForm.type') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Excerpt -->
                @if (false === $this->isEvent())
                    <div class="input-group my-3 last:mb-0 first:mt-0">
                        <label for="excerpt" class="uppercase">
                            {{ __('Excerpt') }}
                            <i class="text-red-500">*</i>
                        </label>
                        <textarea 
                            name="excerpt" 
                            id="excerpt" 
                            required
                            class="border-1 border-gray-300 rounded block w-full"
                            wire:model.blur="createPostForm.excerpt"></textarea>
                        
                        @error('createPostForm.excerpt') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                @endif

                <!-- Content -->
                <div class="input-group my-3 last:mb-0 first:mt-0">
                    <label for="content-form" class="uppercase">
                        {{ __('Content') }}
                        <i class="text-red-500">*</i>
                    </label>
                    @if ($this->isEvent())
                        <input 
                            name="content" 
                            id="content-form" 
                            class="border-1 border-gray-300 rounded block w-full"
                            required 
                            wire:model.blur="createPostForm.content" />
                    @else
                        <textarea 
                            name="content" 
                            id="content-form" 
                            class="border-1 border-gray-300 rounded block w-full"
                            rows="10"
                            required
                            wire:model.blur="createPostForm.content"></textarea>
                    @endif

                    @error('createPostForm.content') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            </section>

            <!-- Attachments -->
            @if (false === $this->isEvent())
                <section class="attachments">
                    <div class="w-full bg-white border-1 border-gray-300 rounded shadow-md p-3 mt-3">
                        <h3 class="text-2xl text-gray-600 mb-3">{{ __('Add attachment') }}</h3>

                        <input 
                            type="file" 
                            name="attachments[]"
                            id="attachments" 
                            accept="{{ implode(',', $this->getAcceptedMimeTypes()) }}" 
                            size="{{ config('swiatov.max_file_size') }}"
                            wire:model="createPostForm.attachments"
                            multiple>
                        @error('createPostForm.attachments') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </section>    
            @endif
        </section>
        <section class="right-side w-1/4 font-primary">
            <!-- Category -->
            <aside class="aside-card">
                <h3 class="text-md pt-0 mt-0 uppercase">
                    {{ __('Choose category') }}
                    <i class="text-red-600">*</i>
                </h3>

                <select name="category" id="category" required wire:model="createPostForm.categoryId" class="w-full mt-3">
                    <option readonly selected value="">-- {{ __('Select category') }} -- </option>
                    @forelse ($categories as $category)
                        <option value="{{ $category->getKey() }}">{{ ucfirst($category->getName()) }}</option>
                    @endforeach
                </select>
                @error('createPostForm.categoryId') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                <button 
                    type="button" 
                    class="outline-none bg-none text-cyan-500 hover:text-cyan-600 active:text-cyan-800 dark:text-white mt-3 flex items-center">
                    <span class="material-symbols-outlined text-base mr-1">
                        add_circle
                    </span>
                    <span class="text-base">{{ __('create new category') }}</span>
                </button>
            </aside>

            <!-- Tags -->
            <aside class="aside-card">
                <h3 class="text-md pt-0 mt-0 uppercase">{{ __('Select tags') }}</h3>

                <select name="tags" id="tags" wire:model="createPostForm.tags" class="w-full mt-3" multiple>
                    @forelse ($tags as $tag)
                        <option value="{{ $tag->getKey() }}">{{ ucfirst($tag->getName()) }}</option>
                    @endforeach
                </select>

                @error('createPostForm.tags') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </aside>

            <!-- Thumbnail -->
            @if(false === $this->isEvent())
            <!-- @TODO: Thumbnail should be selected by attachments tab. -->
                <aside class="aside-card">
                    <div class="thumbnail-url">
                        <h3 class="text-md pt-0 mt-0 uppercase">{{ __('Select thumbnail')}}</h3>

                        <input 
                            type="file" 
                            name="thumbnail_url" 
                            id="thumbnail_url" 
                            class="from-control mt-3" 
                            accept="image/png, image/jpgeg, image/svg, image/tiff, image/bmp"
                            wire:model="createPostForm.thumbnailPath">

                        @error('createPostForm.thumbnailPath') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </aside>
            @endif

            <!-- Publishable date time -->
            @if ($this->canBePublished())
                <aside class="aside-card">
                    <div class="publishable-date">
                        <h3 class="text-md pt-0 mt-0 uppercase">{{ __('Delay post publishing')}}</h3>

                        <input 
                                type="datetime-local" 
                                name="publishableDateTime" 
                                id="publishableDateTime" 
                                class="from-control mt-3"
                                wire:model="createPostForm.publishableDateTime">

                        @error('createPostForm.publishableDateTime') <span class="text-red-600 text-sm block">{{ $message }}</span> @enderror
                    </div>
                </aside>
            @endif
        </section>
    </div>
</form>