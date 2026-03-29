@props([
    'type' => 'success',
    'message' => null,
])

@if ($message)
    <div
        class="mb-4 p-3 rounded-md border
        @if ($type === 'success') bg-green-100 text-green-800 border-green-300
        dark:bg-green-900 dark:text-green-100 dark:border-green-700 @endif
        ">
        {{ $message }}
    </div>
@endif
