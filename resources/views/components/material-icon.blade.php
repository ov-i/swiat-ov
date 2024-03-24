@props(['classes' => null, 'iconType' => 'material-symbols-outlined'])

<div class="icon mr-1">
    <span {{ $attributes->merge(['class' => "$iconType $classes dark:text-white block"]) }}>
        {{ $slot }}
    </span>
</div>  