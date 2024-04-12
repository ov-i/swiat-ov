@props(['withId' => null])

<section class="overflow-x-scroll lg:overflow-x-visible">
  <table {{ $attributes->merge(['class' => 'min-w-full table-fixed divide-y divide-gray-300 text-gray-800']) }}>
    {{ $slot }}
  </table>
</section>
