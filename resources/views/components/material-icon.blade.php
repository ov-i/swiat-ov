@props(['classes' => null, 'iconType' => 'material-symbols-outlined'])

<div class="icon">
    <span {{ $attributes->merge(['class' => "$iconType $classes dark:text-white"]) }}>
        {{ $slot }}
    </span>
</div>  