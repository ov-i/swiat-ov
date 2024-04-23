@props(['relation', 'resource'])

@if ($relation->count())
  <x-resource-table>
    {{ $slot }}
  </x-resource-table>
@else
  <x-not-found-resource :$resource :link="route('admin.attachments')" />
@endif