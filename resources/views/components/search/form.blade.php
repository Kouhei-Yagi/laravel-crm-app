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

        {{-- ボタン --}}
        <div class="flex justify-end mt-4 gap-3">
            <a href="{{ $action }}"
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400
                dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                クリア
            </a>

            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700
                dark:bg-blue-500 dark:hover:bg-blue-600">
                検索
            </button>
        </div>
    </div>
</form>
