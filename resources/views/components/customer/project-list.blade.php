<h3 class="text-lg font-semibold mt-10 mb-3 text-gray-800 dark:text-gray-100">
    案件一覧（{{ $projects->count() }}件）
</h3>

@if ($projects->isEmpty())
    <p class="text-gray-500 dark:text-gray-400">案件はありません。</p>
@else
{{-- 一覧データ --}}
    <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">

        {{-- ヘッダー --}}
        <thead>
            <tr class="bg-gray-50 dark:bg-gray-700">

                {{-- 案件名 --}}
                <th class="px-3 py-2 border">案件名</th>

                {{-- ステータス --}}
                <th class="px-3 py-2 border">ステータス</th>

                {{-- 税抜金額 --}}
                <th class="px-3 py-2 border">税抜金額</th>

                {{-- 期間 --}}
                <th class="px-3 py-2 border">期間</th>

                {{-- 担当者 --}}
                <th class="px-3 py-2 border">担当者</th>

                {{-- 作成日 --}}
                <th class="px-3 py-2 border">作成日</th>

            </tr>
        </thead>

        {{-- レコード --}}
        <tbody>
            @foreach ($projects as $project)
                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">

                    {{-- 案件名 --}}
                    <td class="px-3 py-2 border">
                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">
                            {{ $project->title }}
                        </a>
                    </td>

                    {{-- ステータス --}}
                    <td class="px-3 py-2 border">
                        {{ $project->status_label }}
                    </td>

                    {{-- 税抜金額 --}}
                    <td class="px-3 py-2 border">
                        {{ number_format($project->amount) ?: '未設定'}}
                    </td>

                    {{-- 期間 --}}
                    <td class="px-3 py-2 border">
                        {{ optional($project->start_date)->format('Y-m-d') ?: '未設定' }}
                        ～
                        {{ optional($project->end_date)->format('Y-m-d') ?: '未設定' }}
                    </td>

                    {{-- 担当者 --}}
                    <td class="px-3 py-2 border">
                        {{ $project->assignedUser->name }}
                    </td>

                    {{-- 作成日 --}}
                    <td class="px-3 py-2 border">
                        {{ $project->created_at->format('Y-m-d') }}
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>
@endif
