@extends('layouts.main')

@section('title')
    {{ __('Strona główna') }}
@endsection

@section('meta')
    <meta name="description" content="Świat OV - platforma dla ludzi z pasją">
    <mete name="keywords" content="Świat OV, pasja, hobby, nauka, kuchnia, medycyna, programowanie, cyberbezpieczeństwo">
    <meta name="author" content="Bartosz Pazdur">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">

    {{-- Facebook ogs --}}
    <meta property="og:title" content="Świat OV - platforma dla ludzi z pasją">
    <meta property="og:description" content="Świat OV - platforma dla ludzi z pasją">
    <meta property="og:image" content="{{ asset('images/swiat-ov.svg') }}">
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Świat OV">
    <meta property="og:locale" content="pl_PL">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@swiat_ov">
    <meta name="twitter:creator" content="@bartosz_pazdur">
    <meta name="twitter:title" content="Świat OV - platforma dla ludzi z pasją">
    <meta name="twitter:description" content="Świat OV - platforma dla ludzi z pasją">
    <meta name="twitter:image" content="{{ asset('images/swiat-ov.svg') }}">
    <meta name="twitter:url" content="{{ route('home') }}">
@endsection

@section('content')
    <livewire:event-banner />

    <section class="w-full lg:w-11/12 2xl:w-8/12 v-large:w-6/12 mx-auto p-4 lg:p-0 lg:py-4">
        <section class="wall-wrapper flex flex-col-reverse md:inline-grid md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 items-start">
            <aside class="left-sidebar col-span-1 w-full md:w-auto">
                <x-card class="w-full mx-auto">
                    <x-card.header class="border-b border-zinc-200 dark:border-gray-600 pb-1">
                        <h2 class="text-md text-gray-600 dark:text-white font-secondary">
                            Hej! Witaj w naszym świecie!
                        </h2>
                    </x-card.header>

                    <x-card.body class="pt-3">
                        <p class="text-sm text-gray-500 dark:text-zinc-400 font-primary">
                            Miło nam Cię powitać na naszej platformie. Stworzyliśmy ją z myślą o ludziach,
                            którzy posiadają szerokie spektrum zainteresowań. Niezależnie od tego, czy interesuję Cię
                            <span>Medycyna</span>, <span>Kulinaria</span>, <span>Programowanie</span>, Cyberbezpieczeństwo,
                            jesteśmy pewni, że znajdziesz coś dla siebie.
                        </p>
                    </x-card.body>
                </x-card>

                <div class="sub-cards block">
                    {{-- Kategorie --}}
                    <section class="mt-3 w-full mx-auto">
                        <x-card>
                            <x-card.header>
                                <h2 class="text-md text-gray-600 dark:text-white font-secondary">
                                    Kategorie
                                </h2>
                            </x-card.header>    
                            <x-card.body>
                                <x-scrollable-list>
                                    <x-scrollable-list.list>
                                        @foreach (\App\Models\Posts\Category::select('name')->get() as $category)
                                            <li class="border-b border-zinc-200 dark:border-gray-600 last:border-none first:pt-0 last:pb-0 py-1">
                                                <a href="{{ route('home') }}" class="text-zinc-500 ">
                                                    {{ $category->getName() }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </x-scrollable-list.list>
                                </x-scrollable-list>
                            </x-card.body>
                        </x-card>
                    </section>

                    {{-- Popularne tago --}}
                    <section class="mt-3 w-full mx-auto">
                        <x-card>
                            <x-card.header>
                                <h2 class="text-md text-gray-600 dark:text-white font-secondary">
                                    Popularne tagi
                                </h2>
                            </x-card.header>    
                            <x-card.body>
                                <x-scrollable-list>
                                    <x-scrollable-list.list>
                                        @forelse (\App\Models\Posts\Tag::select('name')->get() as $tag)
                                            <li class="border-b border-zinc-200 last:border-none first:pt-0 last:pb-0 py-1">
                                                <A href="{{ route('home') }}" class="text-zinc-500 ">
                                                    {{ __("#{$tag->getName()}") }}
                                                </A>
                                            </li>
                                        @empty
                                            <li class="border-b border-zinc-200 last:border-none first:pt-0 last:pb-0 py-1">
                                                <A href="{{ route('home') }}" class="text-zinc-500 ">
                                                    {{ __('Brak tagów') }}
                                                </A>
                                            </li>
                                        @endforelse
                                    </x-scrollable-list.list>
                                </x-scrollable-list>
                            </x-card.body>
                        </x-card>
                    </section>

                    {{-- Inne - Zasady użytkowania, prywatność etc --}}
                    <section class="mt-3 w-full mx-auto">
                        <x-card>
                            <x-card.header>
                                <h2 class="text-md text-gray-600 dark:text-white font-secondary">
                                    Inne
                                </h2>
                            </x-card.header>    
                            <x-card.body>
                                <x-scrollable-list>
                                    <x-scrollable-list.list>
                                        <li class="border-b border-zinc-200 dark:border-gray-600 last:border-none first:pt-0 last:pb-0 py-1">
                                            <A href="{{ route('home') }}" class="text-zinc-500 ">
                                                {{ __('Zasady użytkowania') }}
                                            </A>
                                        </li>
                                        <li class="border-b border-zinc-200 dark:border-gray-600 last:border-none first:pt-0 last:pb-0 py-1">
                                            <A href="{{ route('home') }}" class="text-zinc-500 ">
                                                {{ __('Polityka prywatności') }}
                                            </A>
                                        </li>
                                    </x-scrollable-list.list>
                                </x-scrollable-list>
                            </x-card.body>
                        </x-card>
                    </section>
                </div>

                <section class="w-full md:w-64 text-wrap mt-3">
                    <p class="text-zinc-400">
                        Stworzone z pasją z użyciem
                        <x-icon.heart class="inline" />
                        i PHP/Laravel przez
                        <span class="text-zinc-400 font-semibold">
                            Bartosz Pazdur &copy; {{ date('Y') }}r. 
                        </span>
                    </p>
                </section>
            </aside>

            <main class="w-full md:col-span-2 lg:col-span-3">
                <livewire:posts-wall :$posts />
            </main>
            
            {{-- Prawy aside --}}
            <aside class="left-sidebar col-span-1 w-full md:w-auto hidden xl:block">
                <x-card class="w-full mx-auto">
                    <x-card.header class="border-b border-zinc-200 dark:border-gray-600 pb-1">
                        <h2 class="text-md text-gray-600 font-secondary">
                            Najwyżej oceniane artykuły
                        </h2>
                    </x-card.header>

                    <livewire:most-rated-posts />
                </x-card>

                <x-card class="mt-3">
                    <x-card.header>
                        <img src="https://unsplash.it/1200/900" alt="Survey image" class="object-cover w-80">
                    </x-card.header>
                    <x-card.body class="mt-3">
                        <p class="text-sm text-gray-500 font-primary">
                            Proszę, poświęć chwilę aby wypełnić naszą <a href="#" class="text-cyan-600 border-b border-dashed"> ankietę </a>. Jeżeli masz pomysł na 
                            rozbudowę naszej platformy, chętnie wysłuchamy Twoich sugestii.
                        </p>
                    </x-card.body>
                </x-card>
            </aside>
        </section>
    </section>
@endsection