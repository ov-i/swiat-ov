@if (filled($this->event()))
    <section class="w-full p-3 bg-red-600 text-gray-100 dark:text-white">
        <section class="flex items-center gap-2 justify-center text-center">
            <x-icon.information-circle />

            <a href="{{ $this->event()->getContent() }}">{{ $this->event()->getTitle() }}</a>
        </section>
    </section>
@endif