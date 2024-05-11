@props(['condition'])

@if($condition)
    <x-icon.check-circle class="text-green-600" />
@else
    <x-material-icon class="text-red-600">
        dangerous
    </x-material-icon>
@endif