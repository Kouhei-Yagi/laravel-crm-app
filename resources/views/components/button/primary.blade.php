@props([
    'href' => null,
    'type' => 'button',
])

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->class([
            'inline-block px-4 py-2 text-sm font-medium text-white rounded-md',
            'bg-blue-600 hover:bg-blue-700',
            'dark:bg-blue-500 dark:hover:bg-blue-600',
        ]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->class([
            'inline-block px-4 py-2 text-sm font-medium text-white rounded-md',
            'bg-blue-600 hover:bg-blue-700',
            'dark:bg-blue-500 dark:hover:bg-blue-600',
        ]) }}
    >
        {{ $slot }}
    </button>
@endif
