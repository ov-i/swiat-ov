@props(['errorTarget' => ''])

<select 
  @class([
    'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full',
    'border-2 border-red-500' => $errors->has($errorTarget)
  ]) {{ $attributes }}>
  {{ $slot }}
</select>
