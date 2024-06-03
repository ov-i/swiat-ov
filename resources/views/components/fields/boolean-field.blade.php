@props(['condition'])

@if($condition)
    <x-icon.check-circle class="text-green-600" />
@else
    <x-icon.dangerous class="text-red-600" />
@endif