@props(['value'])

<label {{ $attributes->merge(['class' => 'mt-1 px-2 block text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
