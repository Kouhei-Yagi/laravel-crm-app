@props([
    'action', // 検索フォームの action
    'title' => '検索条件', // タイトル
])

<form action="{{ $action }}" method="get">
    <div class="border border-gray-300 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-700">
    {{ $slot }}
    </div>
</form>
