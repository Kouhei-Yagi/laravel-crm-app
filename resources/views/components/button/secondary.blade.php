@props([
    'href' => null,
    'type' => 'button',
])

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->class([
            'inline-block px-4 py-2 text-sm font-medium text-white rounded-md',
            'bg-gray-500 hover:bg-gray-600',
            'dark:bg-gray-400 dark:hover:bg-gray-500',
        ]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->class([
            'inline-block px-4 py-2 text-sm font-medium text-white rounded-md',
            'bg-gray-500 hover:bg-gray-600',
            'dark:bg-gray-400 dark:hover:bg-gray-500',
        ]) }}
    >
        {{ $slot }}
    </button>
@endif
