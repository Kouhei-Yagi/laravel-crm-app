<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">

            {{-- タイトル --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                案件履歴一覧
            </h2>

            {{-- ボタン --}}
            <x-button.primary href="{{ route('interactions.create') }}">
                新規作成
            </x-button.primary>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    <x-alert :message="session('success')" />

                    {{-- 検索フォーム --}}
                    <x-search.form :action="route('interactions.index')">

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

                    </x-search.form>

                    {{-- 一覧データ --}}
                    <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">

                        {{-- 項目名 --}}
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                {{-- 対応日時 --}}
                                <th class="px-3 py-2 border">
                                    {{-- 検索条件保持ソート機能 --}}
                                    <a href="{{ route(
                                        'interactions.index',
                                        array_merge(request()->query(), [
                                            'sort' => 'interacted_at',
                                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                                        ]),
                                    ) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                        対応日時
                                    </a>

                                    @if (request('sort') === 'interacted_at')
                                        @if (request('direction') === 'asc')
                                            <span class="text-xs">▲</span>
                                        @elseif(request('direction') === 'desc')
                                            <span class="text-xs">▼</span>
                                        @endif
                                    @endif
                                </th>

                                {{-- 対応種別 --}}
                                <th class="px-3 py-2 border">対応種別</th>

                                {{-- 内容 --}}
                                <th class="px-3 py-2 border">内容</th>

                                {{-- 案件名 --}}
                                <th class="px-3 py-2 border">案件名</th>

                                {{-- 顧客名 --}}
                                <th class="px-3 py-2 border">
                                    {{-- 検索条件保持ソート機能 --}}
                                    <a href="{{ route(
                                        'interactions.index',
                                        array_merge(request()->query(), [
                                            'sort' => 'customer_kana',
                                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                                        ]),
                                    ) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                        顧客名
                                    </a>

                                    @if (request('sort') === 'customer_kana')
                                        @if (request('direction') === 'asc')
                                            <span class="text-xs">▲</span>
                                        @elseif(request('direction') === 'desc')
                                            <span class="text-xs">▼</span>
                                        @endif
                                    @endif
                                </th>

                                {{-- 担当者 --}}
                                <th class="px-3 py-2 border">担当者</th>
                            </tr>
                        </thead>

                        {{-- レコード --}}
                        <tbody>
                            @foreach ($interactions as $interaction)
                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">

                                    {{-- 対応日時 --}}
                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('interactions.show', $interaction) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $interaction->interacted_at->format('Y-m-d H:i') }}
                                        </a>
                                    </td>

                                    {{-- 対応種別 --}}
                                    <td class="px-3 py-2 border">
                                        {{ App\Models\Interaction::TYPE[$interaction->type] }}
                                    </td>

                                    {{-- 内容 --}}
                                    <td class="px-3 py-2 border">
                                        {{ Str::limit($interaction->content, 30) }}
                                    </td>

                                    {{-- 案件名 --}}
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

                                    {{-- 顧客名 --}}
                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('customers.show', $interaction->customer) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $interaction->customer->name }}
                                        </a>
                                    </td>

                                    {{-- 担当者 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $interaction->assignedUser->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- ページネーション --}}
            <div class="mt-4">
                {{ $interactions->links() }}
            </div>

        </div>
    </div>
    </div>
</x-app-layout>
