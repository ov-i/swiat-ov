@if (auth()->user()->can('write-post'))
  <a href="{{ route('admin.posts.create') }}" wire:navigate class="flex items-center gap-2 button-info">
    <x-icon.plus-circle />
    {{ $slot }}
  </a>
@endif