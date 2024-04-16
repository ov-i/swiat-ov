@props(['withId' => null])

<section class="overflow-x-auto">
  <table {{ $attributes->merge(['class' => 'min-w-full table-fixed divide-y divide-gray-300 text-gray-800']) }}>
    {{ $slot }}
  </table>
</section>
