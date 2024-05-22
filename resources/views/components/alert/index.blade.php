@props(['type' => 'info'])

@php

$colors = [
    'info' => 'bg-blue-500',
    'warning' => 'bg-yellow-500',
    'success' => 'bg-green-500',
    'danger' => 'bg-red-500',
];

@endphp

<div {{ $attributes->merge(['class' => "{$colors[$type]} shadow-md rounded-md p-3 font-secondary"]) }}>
  {{ $slot }}    
</div>