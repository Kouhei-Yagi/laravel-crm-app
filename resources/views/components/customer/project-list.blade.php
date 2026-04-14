<h3 class="text-lg font-semibold mt-10 mb-3 text-gray-800 dark:text-gray-100">
    案件一覧（{{ $projects->count() }}件）
</h3>

@if ($projects->isEmpty())
    <p class="text-gray-500 dark:text-gray-400">案件はありません。</p>
@endif
