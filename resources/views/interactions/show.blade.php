<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- タイトル --}}
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                対応履歴詳細
            </h2>

            {{-- ボタン --}}
            <div class="flex items-center gap-3">
                @can('update', $interaction)
                    <x-button.primary href="{{ route('interactions.edit', $interaction) }}">
                        編集
                    </x-button.primary>
                @endcan

                @can('delete', $interaction)
                    <form action="{{ route('interactions.destroy', $interaction) }}" method="post" class="inline-block">
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    <x-alert :message="session('success')" />

                    {{-- 詳細データ --}}
                    <table class="min-w-full w-full border border-gray-200 dark:border-gray-600 text-sm">
                        <tbody>

                            @foreach ([
                                '対応日時' => e($interaction->interacted_at->format('Y-m-d H:i')),
                                '対応種別' => e($interaction->type_label),
                                '案件名' => $interaction->project
                                    ? '<a href="' . route('projects.show', $interaction->project) . '" class="text-blue-600 hover:underline">' . e($interaction->project->title) . '</a>'
                                    : '未設定',
                                '顧客名' => '<a href="' . route('customers.show', $interaction->customer) . '" class="text-blue-600 hover:underline">' . e($interaction->customer->name) . '</a>',
                                '担当者' => e($interaction->assignedUser->name),
                                '作成日' => e($interaction->created_at->format('Y-m-d')),
                                '更新日' => e($interaction->updated_at->format('Y-m-d')),
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

                            {{-- 内容（複数行対応） --}}
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 w-40 text-left">
                                    内容
                                </th>
                                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600 whitespace-pre-line break-words">{{ $interaction->content }}</td>
                            </tr>

                            {{-- メモ（複数行対応） --}}
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 w-40 text-left">
                                    メモ
                                </th>
                                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600 whitespace-pre-line break-words">{{ $interaction->memo ?: '未設定' }}</td>
                            </tr>

                        </tbody>
                    </table>

                    {{-- ボタン --}}
                    <div class="flex items-center gap-4 mt-6">
                        <x-button.secondary href="{{ route('interactions.index') }}">
                            一覧に戻る
                        </x-button.secondary>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
