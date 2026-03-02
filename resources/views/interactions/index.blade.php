<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                案件履歴一覧
            </h2>

            {{-- ボタン --}}
            <a href="{{ route('interactions.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                新規作成
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    @if (session('success'))
                        <div
                            class="mb-4 p-3 rounded-md bg-green-100 text-green-800 border border-green-300 dark:bg-green-900 dark:text-green-100 dark:border-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- 検索フォーム --}}
                    <form action="{{ route('interactions.index') }}" method="get" class="mb-6">
                        <div
                            class="border border-gray-300 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-700">

                            {{-- タイトル --}}
                            <div class="mb-3 pb-2 border-b border-gray-300 dark:border-gray-600">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">検索条件</span>
                            </div>

                            {{-- 検索項目 --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                                {{-- 対応日時（from/to） --}}
                                <div>
                                    <label for="interacted_from" class="block text-sm font-medium mb-1">
                                        対応日時
                                    </label>

                                    <div class="flex items-center gap-2">
                                        <input type="date" name="interacted_from" id="interacted_from"
                                            value="{{ request('interacted_from') }}"
                                            class="w-40 px-3 py-2 border border-gray-300 rounded-md
                                            dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">

                                        <span class="text-gray-600 dark:text-gray-300">〜</span>

                                        <input type="date" name="interacted_to" id="interacted_to"
                                            value="{{ request('interacted_to') }}"
                                            class="w-40 px-3 py-2 border border-gray-300 rounded-md
                                            dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                                    </div>
                                </div>

                                {{-- 対応種別 --}}
                                <div>
                                    <label for="type" class="block text-sm font-medium mb-1">
                                        対応種別
                                    </label>

                                    <select name="type" id="type"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md
                                        dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                                        <option value="">未選択</option>
                                        @foreach ($types as $key => $label)
                                            <option value="{{ $key }}" @selected(request('type') == $key)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 内容 --}}
                                <div>
                                    <label for="content_keyword" class="block text-sm font-medium mb-1">
                                        内容
                                    </label>

                                    <input type="text" name="content_keyword" id="content_keyword"
                                        value="{{ request('content_keyword') }}" placeholder="内容で検索"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md
                                        dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                                </div>

                                {{-- 案件名 --}}
                                <div>
                                    <label for="project_keyword" class="block text-sm font-medium mb-1">
                                        案件名
                                    </label>

                                    <input type="text" name="project_keyword" id="project_keyword"
                                        value="{{ request('project_keyword') }}" placeholder="案件名で検索"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md
                                        dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                                </div>

                                {{-- 顧客名 --}}
                                <div>
                                    <label for="customer_id" class="block text-sm font-medium mb-1">
                                        顧客名
                                    </label>

                                    <select name="customer_id" id="customer_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md
                                        dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                                        <option value="">未選択</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" @selected(request('customer_id') == $customer->id)>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 担当者 --}}
                                <div>
                                    <label for="assigned_user_id" class="block text-sm font-medium mb-1">
                                        担当者
                                    </label>

                                    <select name="assigned_user_id" id="assigned_user_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md
                                        dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                                        <option value="">未選択</option>
                                        @foreach ($assignedUsers as $assignedUser)
                                            <option value="{{ $assignedUser->id }}" @selected(request('assigned_user_id') == $assignedUser->id)>
                                                {{ $assignedUser->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            {{-- ボタン --}}
                            <div class="mt-4 flex justify-end gap-3">

                                {{-- クリアボタン --}}
                                <a href="{{ route('interactions.index') }}"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400
                                    dark:bg-gray-600 dark:text-gray-100 dark:hover:bg-gray-500">
                                    クリア
                                </a>

                                {{-- 検索ボタン --}}
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700
                                    dark:bg-blue-500 dark:hover:bg-blue-600">
                                    検索
                                </button>

                            </div>

                        </div>
                    </form>

                    {{-- 一覧データ --}}
                    <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-3 py-2 border">対応日時</th>
                                <th class="px-3 py-2 border">対応種別</th>
                                <th class="px-3 py-2 border">内容</th>
                                <th class="px-3 py-2 border">案件名</th>
                                <th class="px-3 py-2 border">顧客名</th>
                                <th class="px-3 py-2 border">担当者</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($interactions as $interaction)
                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('interactions.show', $interaction) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $interaction->interacted_at->format('Y-m-d H:i') }}
                                        </a>
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ App\Models\Interaction::TYPE[$interaction->type] }}
                                    </td>

                                    <td class="px-3 py-2 border">
                                        {{ Str::limit($interaction->content, 30) }}
                                    </td>

                                    <td class="px-3 py-2 border">
                                        @if ($interaction->project)
                                            <a href="{{ route('projects.show', $interaction->project) }}"
                                                class="text-blue-600 hover:underline">
                                                {{ $interaction->project->title }}
                                            </a>
                                        @else
                                            未設定
                                        @endif
                                    </td>

                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('customers.show', $interaction->customer) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $interaction->customer->name }}
                                        </a>
                                    </td>

                                    {{-- ページネーション --}}
                                    <td class="px-3 py-2 border">
                                        {{ $interaction->assignedUser->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- ページネーション（検索条件の保持） --}}
            <div class="mt-4">
                {{ $interactions->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
    </div>
</x-app-layout>
