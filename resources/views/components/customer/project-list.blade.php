<h3 class="text-lg font-semibold mt-10 mb-3 text-gray-800 dark:text-gray-100">
    案件一覧（{{ $projects->count() }}件）
</h3>

{{-- 一覧データ --}}
<table class="min-w-full w-full border border-gray-200 dark:border-gray-600 text-sm mt-6">

    {{-- ヘッダー --}}
    <thead>
        <tr class="bg-gray-100 dark:bg-gray-700">
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">案件名</th>
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">ステータス</th>
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">税抜金額</th>
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">担当者</th>
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">作成日</th>
            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">詳細</th>
        </tr>
    </thead>

    {{-- レコード --}}
    <tbody>
        @forelse ($projects as $project)
            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">

                {{-- 案件名 --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600 break-words">
                    {{ $project->title }}
                </td>

                {{-- ステータス --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                    {{ $project->status_label }}
                </td>

                {{-- 税抜金額 --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                    {{ number_format($project->amount) }} 円
                </td>

                {{-- 担当者 --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                    {{ $project->assignedUser->name }}
                </td>

                {{-- 作成日 --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                    {{ $project->created_at->format('Y-m-d') }}
                </td>

                {{-- 詳細ボタン --}}
                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                    <x-button.secondary href="{{ route('projects.show', $project) }}">
                        詳細
                    </x-button.secondary>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                    案件はありません。
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
