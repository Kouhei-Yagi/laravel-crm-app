<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                顧客一覧
            </h2>

            {{-- ボタン --}}
            <a href="{{ route('customers.create') }}"
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
                            class="mb-4 p-3 rounded-md bg-green-100 text-green-800 border border-green-300
                            dark:bg-green-900 dark:text-green-100 dark:border-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- 検索フォーム --}}
                    <form action="{{ route('customers.index') }}" method="get" class="mb-6">
                        <div
                            class="border border-gray-300 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-700">

                            {{-- タイトル --}}
                            <div class="mb-3 pb-2 border-b border-gray-300 dark:border-gray-600">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">検索条件</span>
                            </div>

                            {{-- 検索項目 --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                                {{-- キーワード --}}
                                <div>
                                    <label for="keyword"class="block text-sm font-medium mb-1">
                                        キーワード
                                    </label>

                                    <input type="text" name="keyword" id="keyword" placeholder="顧客・メール・電話番号・会社名"
                                        value="{{ request('keyword') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
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
                                        @foreach ($assignedUsers as $assignedUser)
                                            <option value="{{ $assignedUser->id }}" @selected(request('assigned_user_id') == $assignedUser->id)>
                                                {{ $assignedUser->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 作成日（from/to） --}}
                                <div class="md:col-span-2 lg:col-span-3">
                                    <label for="created_from" class="block text-sm font-medium mb-1">
                                        作成日
                                    </label>

                                    <div class="flex items-center gap-2">
                                        <input type="date" name="created_from" value="{{ request('created_from') }}"
                                            class="w-40 px-3 py-2 border border-gray-300 rounded-md
                                            dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">

                                        <span class="text-gray-600 dark:text-gray-300">〜</span>

                                        <input type="date" name="created_to" value="{{ request('created_to') }}"
                                            class="w-40 px-3 py-2 border border-gray-300 rounded-md
                                            dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
                                    </div>
                                </div>
                            </div>

                            {{-- ボタン --}}
                            <div class="flex justify-end mt-4 gap-3">
                                <a href="{{ route('customers.index') }}"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400
                                    dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                    クリア
                                </a>

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
                                <th class="px-3 py-2 border">
                                    <a href="{{ route('customers.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                        顧客名
                                    </a>
                                </th>
                                <th class="px-3 py-2 border">メール</th>
                                <th class="px-3 py-2 border">電話番号</th>
                                <th class="px-3 py-2 border">会社名</th>
                                <th class="px-3 py-2 border">ステータス</th>
                                <th class="px-3 py-2 border">担当者</th>
                                <th class="px-3 py-2 border">作成日</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">

                                    {{-- 顧客名 --}}
                                    <td class="px-3 py-2 border">
                                        <a href="{{ route('customers.show', $customer) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $customer->name }}
                                        </a>
                                    </td>

                                    {{-- メール --}}
                                    <td class="px-3 py-2 border">
                                        {{ $customer->email ?: '未設定' }}
                                    </td>

                                    {{-- 電話番号 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $customer->phone ?: '未設定' }}
                                    </td>

                                    {{-- 会社名 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $customer->company_name ?: '未設定' }}
                                    </td>

                                    {{-- ステータス --}}
                                    <td class="px-3 py-2 border">
                                        {{ App\Models\Customer::STATUSES[$customer->status] }}
                                    </td>

                                    {{-- 担当者 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $customer->assignedUser->name }}
                                    </td>

                                    {{-- 作成日 --}}
                                    <td class="px-3 py-2 border">
                                        {{ $customer->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- ページネーション --}}
                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
