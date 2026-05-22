<h3 class="text-lg font-semibold mt-10 mb-3 text-gray-800 dark:text-gray-100">
    対応履歴一覧（{{ $interactions->count() }}件）
</h3>

{{-- 一覧データ --}}
<table class="min-w-full w-full border border-gray-200 dark:border-gray-600 text-sm mt-6">

    {{-- ヘッダー --}}
    <thead>
        <tr class="bg-gray-100 dark:bg-gray-700">
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">対応日</th>
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">対応種別</th>
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">内容</th>
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">担当者</th>
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">詳細</th>
        </tr>
    </thead>

    {{-- レコード --}}
    <tbody>
        @forelse ($interactions as $interaction)
            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">

                {{-- 対応日 --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                    {{ $interaction->interacted_at->format('Y-m-d') }}
                </td>

                {{-- 種別 --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                    {{ $interaction->type_label }}
                </td>

                {{-- 内容（長文対応） --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600 break-words">
                    {{ Str::limit($interaction->content, 50) }}
                </td>

                {{-- 担当者 --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                    {{ $interaction->assignedUser->name }}
                </td>

                {{-- 詳細ボタン --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                    <x-button.secondary href="{{ route('interactions.show', $interaction) }}">
                        詳細
                    </x-button.secondary>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                    対応履歴はありません。
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
