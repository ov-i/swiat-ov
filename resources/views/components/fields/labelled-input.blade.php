@props(['for', 'required' => false])

<x-label class="uppercase" >
    <h3>
        {{ __($for) }}

        @if ($required)
            <span class="text-red-500 opacity-75" aria-hidden="true">*</span>
        @endif
    </h3>
    <x-input {{ $attributes }} />
</x-label>