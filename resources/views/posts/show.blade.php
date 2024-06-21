@extends('layouts.main')

@section('title')
    {{ $post->title }}
@endsection

@section('meta')
    <meta name="description" content="{{ $post->excerpt }}">
    <meta name="keywords" content="świat ov, swiat ov, ov, brittleheart, {{ $post->tags()->pluck('name')->join(', ') }}">
    <meta name="author" content="{{ $post->user->getName() }}">
    <meta name="robots" content="noindex, nofollow">

    {{-- Facebook ogs --}}
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    <meta property="og:image" content="https://unsplash.it/1200/970">
    <meta property="og:url" content="{{ route('posts.show', $post) }}">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="{{ config('app.name') }}">

    {{-- Twitter ogs --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ '@' . config('app.twitter_handle') }}">
    <meta name="twitter:creator" content="{{ '@' . config('app.twitter_handle') }}">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->excerpt }}">
    <meta name="twitter:image" content="{{ $post->getThumbnailPath() }}">
    <meta name="twitter:url" content="{{ route('posts.show', $post) }}">
@endsection

@section('content')
    <section class="w-full lg:w-9/12 2xl:w-6/12 v-large:w-5/12 mx-auto p-4 lg:p-0 lg:py-4">
        <main class="w-full md:col-span-2 lg:col-span-3" id="post-show-main">
            <section class="hidden md:block">
                <x-breadcrumb>
                    <x-breadcrumb.item :href="route('home')" :active="false">
                        {{ __('Strona główna') }} /
                    </x-breadcrumb.item>
                    <x-breadcrumb.item :href="route('posts.show', $post)" :active="true">
                        {{ str($post->toSlug())->limit(30) }}
                    </x-breadcrumb.item>
                </x-breadcrumb>
            </section>

            <div class="post-show-main-wrapper mt-3">
                {{-- @if (!blank($post->getThumbnailPath())) --}}
                <section class="post-show-main-body">
                    <div class="post-show-main-body-image">
                        <img src="https://unsplash.it/1200/970" alt="post image" class="w-full h-100 object-cover rounded">
                    </div>
                </section>
                {{-- @endif --}}

                <section class="mt-4">
                    <section class="content bg-white dark:bg-asideMenu rounded shadow p-4">
                        <section class="mb-4">
                            <section class="flex items-center justify-between">
                                <section class="profile-info">
                                    <div class="flex items-start gap-2">
                                        <img src="{{ $post->user->profile_photo_url }}" alt="User profle image"
                                            class="h-12 w-auto object-cover rounded-full" />

                                        <p class="text-zinc-500 dark:text-white text-base font-secondary">
                                            {{ $post->user->getName() }}

                                            <span class="flex items-center text-gray-400 text-sm">
                                                <x-icon.clock class="!w-4 mr-1" />

                                                {{ $post->created_at->diffForHumans() }}
                                            </span>
                                        </p>
                                    </div>
                                </section>

                                <secton class="flex items-center gap-2 justify-between flex-row-reverse">
                                    <section class="flex items-center gap-2">
                                        @auth
                                            <livewire:post.add-bookmark :$post :user="auth()->user()" />
                                        @endauth
                                    </section>
                                    <section class="flex items-start gap-3 dark:text-zinc-400">
                                        <div>
                                            <section class="flex items-center gap-2">
                                                <x-icon.share />

                                                <p>0</p>
                                            </section>
                                        </div>
                                        <div>
                                            <section class="flex items-center gap-2">
                                                <x-icon.chat-bubble-bottom-center />

                                                <p>{{ $comments->total() }}</p>
                                            </section>
                                        </div>
                                    </section>
                                </secton>
                            </section>
                        </section>

                        <section>
                            <p class="font-secondary text-sm text-zinc-600 dark:text-zinc-200 font-semibold my-4">
                                {{ __('Kategoria: ') }}

                                <span class="font-normal">
                                    {{ $post->category }}
                                </span>
                            </p>

                            @if ($post->isArchived())
                                <x-badge type="warning" class="mb-2 text-md">
                                    {{ __('zarchiwizowane') }}
                                </x-badge>
                            @endif

                            <h1 class="text-4xl font-bold text-zinc-500 dark:text-zinc-200 mb-4">
                                {{ $post->title }}
                            </h1>

                            <section data-content="excerpt" class="my-3">
                                <p class="text-zinc-600 dark:text-zinc-200 text-base font-primary pb-5 border-b border-gray-300 dark:border-gray-700">
                                    {{ $post->excerpt }}
                                </p>
                            </section>

                            @if ($post->tags->count())
                                <section class="flex items-center gap-2">
                                    <p class="text-gray-700 dark:text-zinc-200">{{ __('Tagi: ') }} </p>
                                    @foreach ($post->tags as $tag)
                                        <x-icon.tag class="w-5 h-5 dark:text-white" />

                                        <p class="text-sm text-zinc-600 dark:text-zinc-400 font-secondary">
                                            {{ $tag->getName() }}
                                        </p>
                                    @endforeach
                                </section>
                            @endif
                        </section>


                        <section class="mt-4">
                            <article class="text-zinc-600 dark:text-zinc-200 text-base font-primary pb-5"
                                id="post-content">
                                {!! $post->content !!}
                            </article>

                            <article data-content="attachments">
                                @if (filled($post->attachments))
                                    <section class="mt-4 flex flex-col lg:flex-row items-start lg:items-center gap-2">
                                        <h2 class="text-xl font-semibold text-zinc-500">{{ __('Załączniki') }}</h2>
                                        <livewire:post.download-all-attachments-button :attachments="$post->attachments" />
                                    </section>
                                @endif

                                <section class="mt-4">
                                    <livewire:post.attachments-list :attachments="$post->attachments" />
                                </section>
                            </article>
                        </section>
                    </section>
                </section>
            </div>
        </main>

        @if ($post->isCommentable())
            <section class="mt-12 w-full">
                <section class="w-full">
                    <h2 class="text-xl font-semibold text-zinc-500">
                        {{ __('Komentarze') }}
                        ({{ $comments->total() }})
                    </h2>
                    
                    <livewire:post.widget.comments :$post />
                </section>
            </section>
        @endif
    </section>
@endsection
