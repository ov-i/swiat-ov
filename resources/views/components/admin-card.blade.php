<section class="bg-white dark:bg-asideMenu p-4 rounded-md shadow">
    <section class="heading-wrapper flex items-center justify-between">
        <h1 
          class="text-lg md:text-xl lg:text-2xl font-primary self-start text-gray-600 dark:text-zinc-300">
          {{ __($title) }}
        </h1>

        @if (isset($actions))
          {{ $actions }}
        @endif
    </section>

    {{ $slot }}
</section>