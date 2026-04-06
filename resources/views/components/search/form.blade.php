@props([
    'action', // 検索フォームの action
    'title' => '検索条件', // タイトル
])

<form action="{{ $action }}" method="get">
    <div class="border border-gray-300 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-700">

        {{-- タイトル --}}
        <div class="mb-3 pb-2 border-b border-gray-300 dark:border-gray-600">
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </span>
        </div>

        {{-- 検索項目 --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {{ $slot }}
        </div>

    </div>
</form>
