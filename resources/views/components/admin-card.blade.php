<section class="bg-white p-4 rounded-md shadow">
    <section class="heading-wrapper flex items-center justify-between">
        <h1 class="text-2xl font-primary text-gray-600">{{ __('Posts') }}</h1>

        @if (isset($actions))
          {{ $actions }}
        @endif
    </section>

    {{ $slot }}
</section>