<h3 class="text-lg font-semibold mt-10 mb-3 text-gray-800 dark:text-gray-100">
    案件一覧（{{ $projects->count() }}件）
</h3>

@if ($projects->isEmpty())
    <p class="text-gray-500 dark:text-gray-400">案件はありません。</p>
@else
{{-- 一覧データ --}}
    <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">
        <thead>
            {{-- 項目名 --}}
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
        {{ $slot }}
    </table>
@endif
