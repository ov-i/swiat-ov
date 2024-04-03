@props(['condition'])

@if($condition)
    <x-material-icon class="text-green-600">
        check_circle
    </x-material-icon>
@else
    <x-material-icon class="text-red-600">
        dangerous
    </x-material-icon>
@endif