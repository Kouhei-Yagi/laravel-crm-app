@props([
    'href' => null,
    'type' => 'button',
])

@php
    $classes = 'px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700';
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
