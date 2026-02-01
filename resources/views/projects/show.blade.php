<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            案件詳細ページ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div
                            class="mb-4 p-3 rounded-md bg-green-100 text-green-800 border border-green-300 dark:bg-green-900 dark:text-green-100 dark:border-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full border border-gray-300 dark:border-gray-700 text-sm">
                        <tbody>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border w-40">案件名</th>
                                <td class="px-3 py-2 border">{{ $project->title }}</td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">顧客名</th>
                                <td class="px-3 py-2 border">
                                    @if ($project->customer)
                                        <a href="{{ route('customers.show', $project->customer) }}"
                                            class="text-blue-600 hover:underline">{{ $project->customer->name }}</a>
                                    @else
                                        <span class="text-gray-400">未設定</span>
                                    @endif
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">案件内容</th>
                                <td class="px-3 py-2 border whitespace-pre-line">{{ $project->description ?: '（なし）' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">ステータス</th>
                                <td class="px-3 py-2 border">{{ App\Models\Project::STATUSES[$project->status] }}</td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">税抜金額</th>
                                <td class="px-3 py-2 border">{{ number_format($project->amount) }} 円</td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">期間</th>
                                <td class="px-3 py-2 border">{{ $project->start_date->format('Y-m-d') }} ～
                                    {{ $project->end_date->format('Y-m-d') }}</td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">担当者</th>
                                <td class="px-3 py-2 border">{{ optional($project->user)->name ?: '未設定' }}</td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">メモ</th>
                                <td class="px-3 py-2 border whitespace-pre-line">{{ $project->memo ?: '（なし）' }}</td>
                            </tr>

                        </tbody>
                    </table>

                    {{-- ボタン --}}
                    <div class="flex items-center gap-4 mt-6">
                        <a href="{{ route('projects.edit', $project) }}"
                            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-500">
                            編集
                        </a>

                        <a href="{{ route('projects.index') }}"
                            class="inline-block px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 dark:hover:bg-gray-400">
                            一覧に戻る
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
