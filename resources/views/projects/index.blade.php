<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                案件一覧
            </h2>

            {{-- ボタン --}}
            <a href="{{ route('projects.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                新規作成
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overfmin-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    @if (session('success'))
                        <div
                            class="mb-4 p-3 rounded-md bg-green-100 text-green-800 border border-green-300 dark:bg-green-900 dark:text-green-100 dark:border-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- 検索フォーム --}}
                    <form action="{{ route('projects.index') }}" method="get" class="mb-4">
                        <div class="flex items-center gap-2">

                            {{-- 案件名 --}}
                            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="案件名で検索"
                                class="w-full max-w-sm px-3 py-2 border border-gray-300 rounded-md
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">

                            {{-- 顧客名 --}}
                            <select name="customer_id"
                                class="w-full max-w-sm px-3 py-2 border border-gray-300 rounded-md
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                <option value="">未選択</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(request('customer_id') == $customer->id)>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- ステータス --}}
                            <select name="status"
                                class="w-full max-w-sm px-3 py-2 border border-gray-300 rounded-md
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                <option value="">未選択</option>
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}" @selected(request('status') == $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- 担当者 --}}
                            <select name="assigned_user_id"
                                class="w-full max-w-sm px-3 py-2 border border-gray-300 rounded-md
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                <option value="">未選択</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(request('assigned_user_id') == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- 税抜金額 --}}
                            <input type="number" name="amount_min" value="{{ request('amount_min') }}" min="0"
                                class="w-full max-w-sm px-3 py-2 border border-gray-300 rounded-md
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">

                            ～

                            <input type="number" name="amount_max" value="{{ request('amount_max') }}"
                                class="w-full max-w-sm px-3 py-2 border border-gray-300 rounded-md
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">

                            {{-- ボタン --}}
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700
                                dark:bg-blue-500 dark:hover:bg-blue-600">
                                検索
                            </button>

                        </div>
                    </form>

                    {{-- 一覧データ --}}
                    <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-3 py-2 border">案件名</th>
                                <th class="px-3 py-2 border">顧客名</th>
                                <th class="px-3 py-2 border">ステータス</th>
                                <th class="px-3 py-2 border">税抜金額</th>
                                <th class="px-3 py-2 border">担当者</th>
                                <th class="px-3 py-2 border">期間</th>
                                <th class="px-3 py-2 border">作成日</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($projects as $project)
                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('projects.show', $project) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $project->title }}
                                        </a>
                                    </td>

                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('customers.show', $project->customer) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $project->customer->name }}
                                        </a>
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ App\Models\Project::STATUSES[$project->status] }}
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ number_format($project->amount) ?: '未設定' }}
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ $project->assignedUser->name }}
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ $project->start_date ? $project->start_date->format('Y-m-d') : '未設定' }} ～
                                        {{ $project->end_date ? $project->end_date->format('Y-m-d') : '未設定' }}
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ $project->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ページネーション（検索条件の保持） --}}
                <div class="mt-4">
                    {{ $projects->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
