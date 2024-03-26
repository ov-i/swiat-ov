@props(['type' => 'submit', 'component' => 'button-info'])

<button {{ $attributes->merge(['type' => $type, 'class' => $component]) }}>
    {{ $slot }}
</button>
