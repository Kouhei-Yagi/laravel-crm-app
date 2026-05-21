@props([
    'type' => 'button',
])

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' =>
            'inline-block px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md
            hover:bg-red-700
            dark:bg-red-500 dark:hover:bg-red-600'
    ]) }}
>
    {{ $slot }}
</button>
