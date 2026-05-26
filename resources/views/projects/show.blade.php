<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- タイトル --}}
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                案件詳細
            </h2>

            {{-- ボタン --}}
            <div class="flex items-center gap-3">
                @can('update', $project)
                    <x-button.primary href="{{ route('projects.edit', $project) }}">
                        編集
                    </x-button.primary>
                @endcan

                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}" method="post" class="inline-block">
                        @csrf
                        @method('delete')
                        <x-button.danger type="submit" onclick="return confirm('本当に削除しますか？')">
                            削除
                        </x-button.danger>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 shadow-sm rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    <x-alert :message="session('success')" />

                    {{-- 詳細データ --}}
                    <table class="min-w-full w-full border border-gray-200 dark:border-gray-600 text-sm">
                        <tbody>

                            @foreach ([
                                '案件名' => e($project->title),
                                '顧客名' => '<a href="' . route('customers.show', $project->customer) . '" class="text-blue-600 hover:underline">' . e($project->customer->name) . '</a>',
                                'ステータス' => e($project->status_label),
                                '税抜金額' => $project->amount !== null ? number_format($project->amount) . ' 円' : '未設定',
                                '期間' => ($project->start_date?->format('Y-m-d') ?: '未設定') . ' ～ ' . ($project->end_date?->format('Y-m-d') ?: '未設定'),
                                '担当者' => e($project->assignedUser->name),
                                '作成日' => e($project->created_at->format('Y-m-d')),
                                '更新日' => e($project->updated_at->format('Y-m-d')),
                            ] as $label => $value)

                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                    <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 w-40 text-left">
                                        {{ $label }}
                                    </th>
                                    <td class="px-4 py-2 border border-gray-200 dark:border-gray-600 break-words">
                                        {!! $value !!}
                                    </td>
                                </tr>
                            @endforeach

                            {{-- 案件内容（複数行対応） --}}
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 w-40 text-left">
                                    案件内容
                                </th>
                                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600 whitespace-pre-line break-words">{{ $project->description ?: '未設定' }}</td>
                            </tr>

                            {{-- メモ（複数行対応） --}}
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 w-40 text-left">
                                    メモ
                                </th>
                                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600 whitespace-pre-line break-words">{{ $project->memo ?: '未設定' }}</td>
                            </tr>

                        </tbody>
                    </table>

                    {{-- ボタン --}}
                    <div class="flex items-center gap-4 mt-6">
                        <x-button.secondary href="{{ route('projects.index') }}">
                            一覧に戻る
                        </x-button.secondary>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
