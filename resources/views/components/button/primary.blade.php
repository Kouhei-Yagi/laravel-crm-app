@props([
    'href' => null,
    'type' => 'button',
])

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge([
            'class' =>
            'inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md
            hover:bg-blue-700
            dark:bg-blue-500 dark:hover:bg-blue-600'
        ]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' =>
                'inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md
                hover:bg-blue-700
                dark:bg-blue-500 dark:hover:bg-blue-600'
        ]) }}
    >
        {{ $slot }}
    </button>
@endif
