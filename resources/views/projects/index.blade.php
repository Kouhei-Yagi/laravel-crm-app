<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">

            {{-- タイトル --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                案件一覧
            </h2>

            {{-- ボタン --}}
            <x-button.primary href="{{ route('projects.create') }}">
                新規作成
            </x-button.primary>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overfmin-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    <x-alert :message="session('success')" />

                    {{-- 検索フォーム --}}
                    <x-search.form :action="route('projects.index')">

                        {{-- 案件名 --}}
                        <x-search.input
                            label="案件名"
                            name="keyword"
                            :value="request('keyword')"
                            placeholder="案件名で検索"
                        />

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

                        {{-- ステータス --}}
                        <div>
                            <label for="status" class="block text-sm font-medium mb-1">
                                ステータス
                            </label>

                            <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md
                                dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                                <option value="">未選択</option>
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}" @selected(request('status') == $key)>
                                        {{ $label }}
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
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(request('assigned_user_id') == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 税抜金額（from/to） --}}
                        <div>
                            <label for="amount_min" class="block text-sm font-medium mb-1">
                                税抜金額
                            </label>

                            <div class="flex items-center gap-2">
                                <input type="number" name="amount_min" id="amount_min"
                                    value="{{ request('amount_min') }}" min="0"
                                    class="w-32 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">

                                <span class="text-gray-600 dark:text-gray-300">〜</span>

                                <input type="number" name="amount_max" id="amount_max"
                                    value="{{ request('amount_max') }}"
                                    class="w-32 px-3 py-2 border border-gray-300 rounded-md
                                    dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                            </div>
                        </div>

                        {{-- 期間（from/to） --}}
                        <div>
                            <label for="start_from" class="block text-sm font-medium mb-1">
                                期間
                            </label>

                            <div class="flex items-center gap-2">
                                <input type="date" name="start_from" id="start_from"
                                    value="{{ request('start_from') }}"
                                    class="w-40 px-3 py-2 border border-gray-300 rounded-md
                                    dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">

                                <span class="text-gray-600 dark:text-gray-300">〜</span>

                                <input type="date" name="end_to" id="end_to"
                                    value="{{ request('end_to') }}"
                                    class="w-40 px-3 py-2 border border-gray-300 rounded-md
                                    dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                            </div>
                        </div>

                        {{-- 作成日（from/to） --}}
                        <div class="md:col-span-2 lg:col-span-3">
                            <label for="created_from" class="block text-sm font-medium mb-1">
                                作成日
                            </label>

                            <div class="flex items-center gap-2">
                                <input type="date" name="created_from" id="created_from"
                                    value="{{ request('created_from') }}"
                                    class="w-40 px-3 py-2 border border-gray-300 rounded-md
                                    dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">

                                <span class="text-gray-600 dark:text-gray-300">〜</span>

                                <input type="date" name="created_to" id="created_to"
                                    value="{{ request('created_to') }}"
                                    class="w-40 px-3 py-2 border border-gray-300 rounded-md
                                    dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                            </div>
                        </div>

                    </x-search.form>

                    {{-- 一覧データ --}}
                    <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">

                        {{-- 項目名 --}}
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                {{-- 案件名 --}}
                                <th class="px-3 py-2 border">
                                    {{-- 検索条件保持ソート機能 --}}
                                    <a href="{{ route(
                                        'projects.index',
                                        array_merge(request()->query(), [
                                            'sort' => 'title',
                                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                                        ]),
                                    ) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                        案件名
                                    </a>

                                    @if (request('sort') === 'title')
                                        @if (request('direction') === 'asc')
                                            <span class="text-xs">▲</span>
                                        @elseif (request('direction') === 'desc')
                                            <span class="text-xs">▼</span>
                                        @endif
                                    @endif
                                </th>

                                {{-- 顧客名 --}}
                                <th class="px-3 py-2 border">
                                    {{-- 検索条件保持ソート機能 --}}
                                    <a href="{{ route(
                                        'projects.index',
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
                                        @elseif (request('direction') === 'desc')
                                            <span class="text-xs">▼</span>
                                        @endif
                                    @endif
                                </th>

                                {{-- ステータス --}}
                                <th class="px-3 py-2 border">ステータス</th>

                                {{-- 税抜金額 --}}
                                <th class="px-3 py-2 border">
                                    {{-- 検索条件保持ソート機能 --}}
                                    <a href="{{ route(
                                        'projects.index',
                                        array_merge(request()->query(), [
                                            'sort' => 'amount',
                                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                                        ]),
                                    ) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                        税抜金額
                                    </a>

                                    @if (request('sort') === 'amount')
                                        @if (request('direction') === 'asc')
                                            <span class="text-xs">▲</span>
                                        @elseif (request('direction') === 'desc')
                                            <span class="text-xs">▼</span>
                                        @endif
                                    @endif
                                </th>

                                {{-- 担当者 --}}
                                <th class="px-3 py-2 border">担当者</th>

                                {{-- 期間 --}}
                                <th class="px-3 py-2 border">期間</th>

                                {{-- 作成日 --}}
                                <th class="px-3 py-2 border">
                                    {{-- 検索条件保持ソート機能 --}}
                                    <a href="{{ route(
                                        'projects.index',
                                        array_merge(request()->query(), [
                                            'sort' => 'created_at',
                                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                                        ]),
                                    ) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                        作成日
                                    </a>

                                    @if (request('sort') === 'created_at')
                                        @if (request('direction') === 'asc')
                                            <span class="text-xs">▲</span>
                                        @elseif (request('direction') === 'desc')
                                            <span class="text-xs">▼</span>
                                        @endif
                                    @endif
                                </th>
                            </tr>
                        </thead>

                        {{-- レコード --}}
                        <tbody>
                            @foreach ($projects as $project)
                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">

                                    {{-- 案件名 --}}
                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('projects.show', $project) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $project->title }}
                                        </a>
                                    </td>

                                    {{-- 顧客名 --}}
                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('customers.show', $project->customer) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $project->customer->name }}
                                        </a>
                                    </td>

                                    {{-- ステータス --}}
                                    <td class="px-3 py-2 border">
                                        {{ App\Models\Project::STATUSES[$project->status] }}
                                    </td>

                                    {{-- 税抜金額 --}}
                                    <td class="px-3 py-2 border">
                                        {{ number_format($project->amount) ?: '未設定' }}
                                    </td>

                                    {{-- 担当者 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $project->assignedUser->name }}
                                    </td>

                                    {{-- 期間 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $project->start_date ? $project->start_date->format('Y-m-d') : '未設定' }} ～
                                        {{ $project->end_date ? $project->end_date->format('Y-m-d') : '未設定' }}
                                    </td>

                                    {{-- 作成日 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $project->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ページネーション --}}
                <div class="mt-4">
                    {{ $projects->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
