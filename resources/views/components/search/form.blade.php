@props([
    'action', // 検索フォームの action
    'title' => '検索条件', // タイトル
])

<form action="{{ $action }}" method="get" {{ $attributes->merge(['class' => 'mb-6']) }}>
    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-5 bg-gray-50 dark:bg-gray-700 shadow-sm">

        {{-- タイトル --}}
        <div class="mb-3 pb-2 border-b border-gray-300 dark:border-gray-600">
            <span class="text-base font-semibold text-gray-800 dark:text-gray-100">
                {{ $title }}
            </span>
        </div>

        {{-- 検索項目 --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {{ $slot }}
        </div>

        {{-- ボタン --}}
        <div class="flex justify-end mt-6 gap-4">
            <x-search.button.clear :href="$action" />
            <x-search.button.submit />
        </div>
    </div>
</form>
