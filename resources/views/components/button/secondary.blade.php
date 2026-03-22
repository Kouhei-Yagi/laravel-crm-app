@props([
    'href' => null,
    'type' => 'button',
])

@php
    $classes = 'inline-block px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 dark:hover:bg-gray-400';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
