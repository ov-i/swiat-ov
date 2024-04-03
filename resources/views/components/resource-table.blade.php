@props(['withId' => null])

<section class="overflow-x-scroll lg:overflow-x-visible">
  <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-white">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-asideMenu dark:text-zinc-500 dark:border-none dark:border-t-2">
      <tr>
        {{ $tableHead }}
      </tr>
    </thead>
    <tbody class="">
      {{ $slot }}
    </tbody>
  </table>
</section>
