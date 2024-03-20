<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-white">
  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-asideMenu dark:text-zinc-500 dark:border-zinc-700 dark:border-t-2">
    <tr>
      <th scope="col" class="p-4">
        <div class="flex items-center">
            <label for="checkbox-all-search" class="sr-only">
              checkbox
            </label>
          <x-checkbox id="checkbox-all-search" />
        </div>
      </th>
      <th scope="col" class="px-6 py-3 text-md">#</th>

      {{ $tableHead }}
    </tr>
  </thead>
  <tbody>
    {{ $slot }}
  </tbody>
</table>
              