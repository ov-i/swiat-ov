@props(['withId' => null])

<section class="overflow-x-scroll lg:overflow-x-visible">
  <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-white">
    {{ $slot }}
  </table>
</section>
