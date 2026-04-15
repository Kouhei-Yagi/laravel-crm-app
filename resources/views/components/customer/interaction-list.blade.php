<h3 class="text-lg font-semibold mt-10 mb-3 text-gray-800 dark:text-gray-100">
    対応履歴一覧（{{ $interactions->count() }}件）
</h3>

@if ($interactions->isEmpty())
    <p class="text-gray-500">対応履歴はありません。</p>
@endif
