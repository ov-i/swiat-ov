@props([
    'placeholder', 
    'collection', 
    'hasProperties' => false, 
    'property' => null, 
    'align' => 'left'
])

<article class="filter first:mx-0 last:mx-0 mx-4">
    <x-dropdown align="{{ $align }}" contentClasses="py-2 px-2 bg-white dark:bg-gray-700 leading-6">
        <x-slot name="trigger">
            <x-input placeholder="{{ $placeholder }}" readonly />
        </x-slot>
        <x-slot name="content">
            <ul class="list-none">
                @foreach ($collection as $item)
                    @if ($hasProperties)
                        <li wire:key="{{ $item }}">{{ $item->{$property} }}</li>
                    @else
                        <li wire:key="{{ $item }}">{{ $item }}</li>
                    @endif
                @endforeach
            </ul>
        </x-slot>
    </x-dropdown>
</article>