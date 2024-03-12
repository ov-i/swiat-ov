<form wire:submit="edit">
    <section class="wrapper-heading flex flex-row items-center justify-between w-2/3 mb-3 font-primary">
        <article class="wrapper-header mb-3">
            <h1 class="font-secondary text-2xl">{{ $this->post() }}</h1>
            @if (filled($this->updatePostForm->title))
                <p class="text-sm text-gray-600">{{ $this->getPostPublicUri() }}</p>
            @endif
        </article>
        <article class="cta flex flex-row justify-right items-center">
            <button
                class="button-info-outlined disabled:cursor-not-allowed disabled:bg-transparent disabled:text-gray-400 hover:border-initial"
                {{ $this->isFormUnTouched() ? 'disabled' : null }}>
                {{ $this->isFormUnTouched() ? __('Form untouched') : __('Edit') }}
            </button>
        </article>
    </section>
    <div class="wrapper-main flex flex-row items-start justify-between font-secondary">
        <section class="left-side-wrapwper w-2/3">
            <section class="left-side w-full bg-white border-1 border-gray-300 rounded shadow-md p-3">
                <!-- Title -->
                <div class="input-group my-3 last:mb-0 first:mt-0">
                    <label for="title" class="uppercase">{{ __('Title') }}<i class="text-red-500">*</i></label>
                    <input type="text" name="title" class="border-1 rounded border-gray-300 w-full block"
                        autocomplete="off" id='title' required autofocus minlength="3" maxlength="120"
                        spellcheck="true" wire:model.live   ="updatePostForm.title" />

                    @error('updatePostForm.title')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Type -->
                <div class="input-group my-3 last:mb-0 first:mt-0">
                    <label for="type" class="uppercase">
                        {{ __('Type') }}
                        <i class="text-red-500">*</i>
                    </label>
                    <select name="type" id="type" class="border-1 rounded border-gray-300 w-full block" required
                        wire:model.live="updatePostForm.type">
                        <option readonly value="" class="text-gray-100">
                            -- {{ __('Post type') }} --
                        </option>
                        @foreach (\App\Enums\Post\PostTypeEnum::cases() as $postType)
                            <option value="{{ $postType }}"
                                {{ $this->post()->getType() === $postType->value ? 'selected' : null }}>
                                {{ ucfirst($postType->value) }}
                            </option>
                        @endforeach
                    </select>

                    @error('updatePostForm.type')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Excerpt -->
                @if (false === $this->isEvent())
                    <div class="input-group my-3 last:mb-0 first:mt-0">
                        <label for="excerpt" class="uppercase">
                            {{ __('Excerpt') }}
                            <i class="text-red-500">*</i>
                        </label>
                        <textarea name="excerpt" id="excerpt" required class="border-1 border-gray-300 rounded block w-full"
                            wire:model.blur="updatePostForm.excerpt"></textarea>

                        @error('updatePostForm.excerpt')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <!-- Content -->
                <div class="input-group my-3 last:mb-0 first:mt-0">
                    <label for="content-form" class="uppercase">
                        {{ __('Content') }}
                        <i class="text-red-500">*</i>
                    </label>
                    @if ($this->isEvent())
                        <input name="content" id="content-form" class="border-1 border-gray-300 rounded block w-full"
                            required wire:model.blur="updatePostForm.content" />
                    @else
                        <textarea name="content" id="content-form" class="border-1 border-gray-300 rounded block w-full" rows="10" required
                            wire:model.blur="updatePostForm.content"></textarea>
                    @endif

                    @error('updatePostForm.content')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </section>

            <!-- Attachments -->
            @if (false === $this->post()->isEvent())
                <section class="attachments">
                    <div class="w-full bg-white border-1 border-gray-300 rounded shadow-md p-3 mt-3">
                        <h3 class="text-2xl text-gray-600 mb-3">{{ __('Add attachment') }}</h3>

                        <input type="file" name="attachments[]" id="attachments"
                            accept="{{ implode(',', $this->getAcceptedMimeTypes()) }}"
                            size="{{ config('swiatov.max_file_size') }}" wire:model="updatePostForm.attachments"
                            multiple>
                        @error('updatePostForm.attachments')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
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

                <select name="category" id="category" required wire:model.live="updatePostForm.category_id"
                    class="w-full mt-3">
                    @forelse ($categories as $category)
                        <option value="{{ $category->getKey() }}"
                            {{ $this->getCategory()->getName() === $category->getName() ? 'selected' : null }}>
                            {{ ucfirst($category->getName()) }}
                        </option>
                    @endforeach
                </select>
                @error('updatePostForm.categoryId')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

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
                <h3 class="text-md pt-0 mt-0 uppercase">{{ __('Select tags') }}</h3>

                <select name="tags" id="tags" wire:model.live="updatePostForm.tags" class="w-full mt-3"
                    multiple>
                    @forelse ($tags as $tag)
                        <option value="{{ $tag->getKey() }}"
                            {{ $this->postContainsTag($tag->getName()) ? 'selected' : null }}>
                            {{ ucfirst($tag->getName()) }}
                        </option>
                    @endforeach
                </select>

                @error('updatePostForm.tags')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </aside>
        </section>
    </div>
</form>
