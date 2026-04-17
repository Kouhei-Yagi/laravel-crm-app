<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            案件詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    <x-alert :message="session('success')" />

                    <table class="w-full border border-gray-300 dark:border-gray-700 text-sm">
                        <tbody>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border w-40">案件名</th>
                                <td class="px-3 py-2 border">
                                    {{ $project->title }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">顧客名</th>
                                <td class="px-3 py-2 border">
                                    <a href="{{ route('customers.show', $project->customer) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $project->customer->name }}
                                    </a>
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">案件内容</th>
                                <td class="px-3 py-2 border whitespace-pre-line">{{ $project->description ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">ステータス</th>
                                <td class="px-3 py-2 border">
                                    {{ App\Models\Project::STATUSES[$project->status] }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">税抜金額</th>
                                <td class="px-3 py-2 border">
                                    {{ number_format($project->amount) ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">期間</th>
                                <td class="px-3 py-2 border">
                                    {{ $project->start_date ? $project->start_date->format('Y-m-d') : '未設定' }} ～
                                    {{ $project->end_date ? $project->end_date->format('Y-m-d') : '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">担当者</th>
                                <td class="px-3 py-2 border">
                                    {{ $project->assignedUser->name }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">作成日</th>
                                <td class="px-3 py-2 border">
                                    {{ $project->created_at->format('Y-m-d') }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">更新日</th>
                                <td class="px-3 py-2 border">
                                    {{ $project->updated_at->format('Y-m-d') }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">メモ</th>
                                <td class="px-3 py-2 border whitespace-pre-line">{{ $project->memo ?: '未設定' }}</td>
                            </tr>

                        </tbody>
                    </table>

                    {{-- ボタン --}}
                    <div class="flex items-center gap-4 mt-6">
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

                        <x-button.secondary href="{{ route('projects.index') }}">
                            一覧に戻る
                        </x-button.secondary>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
