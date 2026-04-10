<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">

            {{-- タイトル --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                顧客一覧
            </h2>

            {{-- ボタン --}}
            <x-button.primary href="{{ route('customers.create') }}">
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
                    <x-search.form :action="route('customers.index')">

                        {{-- キーワード --}}
                        <x-search.input
                            label="キーワード"
                            name="keyword"
                            :value="request('keyword')"
                            placeholder="顧客・メール・電話番号・会社名"
                        />

                        {{-- ステータス --}}
                        <x-search.select
                            label="ステータス"
                            name="status"
                            :value="request('status')"
                            :options="$statuses"
                        />

                        {{-- 担当者 --}}
                        <x-search.select
                            label="担当者"
                            name="assigned_user_id"
                            :value="request('assigned_user_id')"
                            :options="$assignedUsers"
                        />

                        {{-- 作成日（from/to） --}}
                        <div class="md:col-span-2 lg:col-span-3">
                            <x-search.date
                                label="作成日"
                                name="created_at"
                                :from="request('created_at_from')"
                                :to="request('created_at_to')"
                            />
                        </div>

                    </x-search.form>

                    {{-- 一覧データ --}}
                    <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">

                        {{-- 項目名 --}}
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                {{-- 顧客名 --}}
                                <x-table.sortable-header
                                    label="顧客名"
                                    column="name"
                                />

                                {{-- メール --}}
                                <x-table.sortable-header
                                    label="メール"
                                    column="email"
                                />

                                {{-- 電話番号 --}}
                                <th class="px-3 py-2 border">電話番号</th>

                                {{-- 会社名 --}}
                                <th class="px-3 py-2 border">
                                    {{-- 検索条件保持ソート機能 --}}
                                    <a href="{{ route(
                                        'customers.index',
                                        array_merge(request()->query(), [
                                            'sort' => 'company_name',
                                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                                        ]),
                                    ) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                        会社名
                                    </a>

                                    @if (request('sort') === 'company_name')
                                        @if (request('direction') === 'asc')
                                            <span class="text-xs">▲</span>
                                        @elseif (request('direction') === 'desc')
                                            <span class="text-xs">▼</span>
                                        @endif
                                    @endif
                                </th>

                                {{-- ステータス --}}
                                <th class="px-3 py-2 border">ステータス</th>

                                {{-- 担当者 --}}
                                <th class="px-3 py-2 border">担当者</th>

                                {{-- 作成日 --}}
                                <th class="px-3 py-2 border">
                                    {{-- 検索条件保持ソート機能 --}}
                                    <a href="{{ route(
                                        'customers.index',
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
