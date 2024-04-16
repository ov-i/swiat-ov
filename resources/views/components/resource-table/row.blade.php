<tr {{ $attributes->merge([
  'class' => 'dark:bg-asideMenu dark:text-white dark:hover:bg-darkAsideMenu '
]) }}>
  {{ $slot }}
</tr>