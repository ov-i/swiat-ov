@props(['resource', 'link'])

<h3 class="font-primary text-lg text-gray-600 lowercase text-center my-5">
    {{ __(sprintf('No %s found, ', str($resource)->plural()->lower())) }}
    
    <a href="{{ $link }}" {{ $attributes->class(["text-cyan-500 underlined hover:text-cyan-700 active:text-cyan-800 dark:text-white"]) }}>
        {{ __('create one here') }}
    </a>
</h3>