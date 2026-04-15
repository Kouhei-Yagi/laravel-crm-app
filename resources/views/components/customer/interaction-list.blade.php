<h3 class="text-lg font-semibold mt-10 mb-3 text-gray-800 dark:text-gray-100">
    対応履歴一覧（{{ $interactions->count() }}件）
</h3>

@if ($interactions->isEmpty())
    <p class="text-gray-500">対応履歴はありません。</p>
@else
    {{-- 一覧データ --}}
    <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">

        {{-- ヘッダー --}}
        <thead>
            <tr class="bg-gray-50 dark:bg-gray-700">

                {{-- 対応日時 --}}
                <th class="px-3 py-2 border">対応日時</th>

                {{-- 対応種別 --}}
                <th class="px-3 py-2 border">対応種別</th>

                {{-- 内容 --}}
                <th class="px-3 py-2 border">内容</th>

                {{-- 担当者 --}}
                <th class="px-3 py-2 border">担当者</th>

                {{-- 関係案件 --}}
                <th class="px-3 py-2 border">関係案件</th>

            </tr>
        </thead>

        {{-- レコード --}}
        <tbody>
            @foreach ($interactions as $interaction)
                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">

                    {{-- 対応日時 --}}
                    <td class="px-3 py-2 border">
                        {{ $interaction->interacted_at->format('Y-m-d H:i') }}
                    </td>

                    {{-- 対応種別 --}}
                    <td class="px-3 py-2 border">
                        {{ App\Models\Interaction::TYPE[$interaction->type] }}
                    </td>

                    {{-- 内容 --}}
                    <td class="px-3 py-2 border">
                        {{ Str::limit($interaction->content, 30) }}
                    </td>

                    {{-- 担当者 --}}
                    <td class="px-3 py-2 border">
                        {{ $interaction->assignedUser->name }}
                    </td>

                    {{-- 関係案件 --}}
                    <td class="px-3 py-2 border">
                        @if ($interaction->project)
                            <a href="{{route('projects.show', $interaction->project)}}" class="text-blue-600 hover:underline">
                                {{ $interaction->project->title }}
                            </a>
                        @else
                            未設定
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endif
