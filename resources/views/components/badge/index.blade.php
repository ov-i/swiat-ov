@props(['type' => 'info'])

@php
    $classes = [
        'info' => 'bg-blue-100 text-blue-800',
        'success' => 'bg-green-100 text-green-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'danger' => 'bg-red-100 text-red-800',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-block px-2 py-1 rounded-full text-xs font-semibold ' . $classes[$type]]) }}>
    {{ $slot }}
</span>
