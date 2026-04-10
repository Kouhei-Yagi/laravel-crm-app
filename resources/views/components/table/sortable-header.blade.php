@props([
    'label',
    'column',
])

@php
    $currentSort = request('sort');
    $currentDirection = request('direction');

    $nextDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';

    $routeName = request()->route()->getName();

    $url = route(
        $routeName,
        array_merge(
            request()->query(), [
                'sort' => $column,
                'direction' => $nextDirection,
            ])
        );
@endphp

<th class="px-3 py-2 border">
    <a href="{{ $url }}"
        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
        {{ $label }}
    </a>
</th>
