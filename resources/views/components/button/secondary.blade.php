@props([
    'href' => null,
    'type' => 'button',
])

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge([
            'class' =>
                'inline-block px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-md
                hover:bg-gray-600
                dark:bg-gray-400 dark:hover:bg-gray-500'
        ]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' =>
                'inline-block px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-md
                hover:bg-gray-600
                dark:bg-gray-400 dark:hover:bg-gray-500'
        ]) }}
    >
        {{ $slot }}
    </button>
@endif
