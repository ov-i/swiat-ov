@props(['iconType' => 'material-symbols-outlined'])

<div class="icon">
    <span {{ $attributes->merge(['class' => "$iconType dark:text-white block"]) }}>
        {{ $slot }}
    </span>
</div>  