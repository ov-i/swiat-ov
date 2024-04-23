@props(['link', 'buttonText'])
@aware(['link'])

<x-resource-relation :title="$buttonText">
    <x-slot:actions>
        <x-relation.button :$link>
            {{ $buttonText }}
        </x-relation.button>
    </x-slot:actions>

    {{ $slot }}
</x-resource-relation>