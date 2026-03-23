@props([
    'type' => 'button',
])

@php
    $classes = 'inline-block px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 dark:hover:bg-red-500';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
