@extends('layouts.main')

@section('title')
    {{ $post->title }}
@endsection

@section('meta')
    <meta name="description" content="{{ $post->excerpt }}">
    <meta name="keywords" content="{{ $post->tags->pluck('name')->join(', ') }}">
    <meta name="author" content="{{ $post->user->getName() }}">
    <meta name="robots" content="noindex, nofollow">

    {{-- Facebook ogs --}}
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    <meta property="og:image" content="{{ $post->getThumbnailPath() }}">
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
                        {{ str($post->toSlug()) }}
                    </x-breadcrumb.item>
                </x-breadcrumb>
            </section>
            
            <section class="mb-8 mt-3">
                <x-alert type="warning">
                    <h3 class="text-xl font-semibold flex items-center gap-2">
                        <x-icon.exclamation-triangle class="text-red-600" />

                        {{ __('universal.attention', locale: 'pl') }}!
                    </h3>

                    <p class="text-md text-white mb-3 mt-2">
                        Wpis zostal zarchiwizony. Oznacza to brak możliwości komentania oraz udostępniania wpisu.
                        Po więcej informacji, prosimy zgłosić się do administratora lub moderatora strony.
                        Serdecznie dziękujemy za zrozumienie.
                    </p>
                </x-alert>
            </section>

            <secton class="flex items-center gap-2 justify-between mt-3">
                <section class="flex items-start gap-3 mb-4">
                    <div>
                        <section class="flex items-center gap-2">
                            <x-icon.share />
        
                            <p>0 udostępnień</p>
                        </section>
                    </div>
                    <div>
                        <section class="flex items-center gap-2">
                            <x-icon.chat-bubble-bottom-center />
        
                            <p>{{ $post->comments->count() }} {{ __('Komentarzy') }}</p>
                        </section>
                    </div>
                </section>

                <section class="flex items-center gap-2">
                    <x-button component="button-info-outlined flex items-center gap-2 text-sm">
                        <x-icon.bookmark class="w-5 h-5" />
        
                        <p>{{ __('Zapisz') }}</p>
                    </x-button>
                </section>
            </secton>

            <div class="post-show-main-wrapper mt-3">
                {{-- @if (!blank($post->getThumbnailPath())) --}}
                    <section class="post-show-main-body">
                        <div class="post-show-main-body-image">
                            <img src="https://unsplash.it/1200/970" alt="post image" class="w-full h-100 object-cover rounded">
                        </div>
                    </section>
                {{-- @endif --}}

                <section class="mt-4">
                    <section class="content bg-white rounded shadow p-4">
                        <section class="mb-4">
                            <section class="flex items-center justify-between">
                                <section class="profile-info">
                                    <div class="flex items-start gap-2">
                                        <img src="{{ $post->user->profile_photo_url }}" alt="User profle image" class="h-12 w-auto object-cover rounded-full" />
                    
                                        <p class="text-zinc-500 text-base font-secondary">
                                            {{ $post->user->getName() }}
                    
                                            <span class="flex items-center text-gray-400 text-sm">
                                                <x-icon.clock class="!w-4 mr-1" />
                
                                                {{ $post->created_at->diffForHumans() }}
                                            </span>
                                        </p>
                                    </div>
                                </section>
                            </section>
                        </section>

                        <section>
                            <p class="font-secondary text-sm text-zinc-600 font-semibold my-5">
                                {{ __('Kategoria: ') }} 
                                
                                <span class="font-normal">
                                    {{ $post->category }}
                                </span>
                            </p>

                            <h1 class="text-4xl font-bold text-zinc-500 mb-4">{{ $post->title }}</h1>

                            <section data-content="excerpt" class="my-3">
                                <p class="text-zinc-600 text-base font-primary pb-5 border-b border-gray-300">
                                    {{ $post->excerpt }}
                                </p>
                            </section>

                            <section class="flex items-center gap-2">
                                <p>{{ __('Tagi: ') }} </p>
                                @forelse ($post->tags as $tag)
                                    <x-icon.tag class="w-5 h-5" />
                
                                    <p class="text-sm text-zinc-600 font-secondary">
                                        {{ $tag->getName() }}
                                    </p>
                                @empty
                                @endforelse
                            </section>
                        </section>


                        <section class="mt-4">
                            <article class="text-zinc-600 text-base font-primary pb-5 border-b border-gray-300" id="post-content">
                                {!! $post->content !!}
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolores vitae placeat reiciendis aliquid quidem nulla doloribus dolorem eum culpa, nihil ab aspernatur voluptates deserunt hic magnam suscipit fuga velit saepe! Nihil non quod deserunt odio nemo accusantium ducimus natus fugiat odit, ratione delectus ex praesentium? Veritatis error assumenda esse asperiores ipsam laudantium iste aperiam numquam facere magnam. Dignissimos veniam neque, eaque, assumenda porro amet similique sit, blanditiis deserunt natus quos perspiciatis suscipit quam est distinctio molestias error laudantium? Mollitia eius dolorem, similique atque animi rem non eos dolore reprehenderit quidem quos praesentium aspernatur, enim excepturi aliquam impedit numquam neque nisi.
                            </article>

                            <article data-content="attachments">
                                @if (filled($post->attachments))
                                    <section class="mt-4" >
                                        <h2 class="text-xl font-semibold text-zinc-500">{{ __('Załączniki') }}</h2>
                                    </section>
                                @endif

                                <section class="mt-4">
                                    @forelse ($post->attachments as $attachment)
                                        <section class="flex items-center gap-2">
                                            <x-icon.paper-clip class="w-5 h-5" />
                    
                                            <p class="text-sm text-zinc-600 font-secondary">
                                                <a href="{{ $attachment->getPublicUrl() }}" class="text-blue-500 hover:underline">
                                                    {{ $attachment->getOriginalName() }}
                                                </a>
                                            </p>
                                        </section>
                                    @empty
                                        
                                    @endforelse
                                </section>
                            </article>
                        </section>
                    </section>
                </section>
            </div>
        </main>

        @if ($post->isCommentable())
            <section class="mt-12">
                <section class="post-show-comments">
                    <h2 class="text-xl font-semibold text-zinc-500">{{ __('Komentarze') }} ({{ $post->comments->count() }})</h2>

                    @auth
                        <section class="mt-4">
                            <section class="flex items-start gap-2">
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="User profile image" class="h-12 w-auto object-cover rounded-full" />
                
                                <form method="POST" class="w-full">
                                    @csrf
                
                                    <input name="comment-content" id="content" placeholder="{{ __('Napisz komentarz...') }}" class="rounded w-full p-3 font-primary focus:ring-0 focus:outline-none !border-none border-b border-gray-400" required />

                                    <x-button component="button-info-outlined" class="p-2 mt-2">
                                        {{ __('Dodaj komentarz') }}
                                    </x-button>
                                </form>
                            </section>
                        </section>
                    @endauth

                    <section class="mt-4">
                        <x-post.comments-list :$post />
                    </section>
                </section>
            </section>
        @endif
  </section>
@endsection