@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block font-medium text-md text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
    {!! $required ? '<i class="text-red-500">*</i>' : null !!}
</label>

