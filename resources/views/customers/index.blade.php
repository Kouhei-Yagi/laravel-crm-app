<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">

            {{-- タイトル --}}
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight">
                顧客一覧
            </h2>

            {{-- ボタン --}}
            <div class="flex gap-2">
                <x-button.secondary :href="route('customers.export', array_merge(
                    request()->all(),
                    ['sort' => request('sort'), 'direction' => request('direction')]
                ))">
                    CSVエクスポート
                </x-button.secondary>

                <x-button.primary href="{{ route('customers.create') }}">
                    新規作成
                </x-button.primary>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 shadow-sm rounded-lg">
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
                    <table class="min-w-full w-full border border-gray-200 dark:border-gray-600 text-sm">

                        {{-- 項目名 --}}
                        <thead class="bg-gray-100 dark:bg-gray-700">
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
                                <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">電話番号</th>

                                {{-- 会社名 --}}
                                <x-table.sortable-header
                                    label="会社名"
                                    column="company_name"
                                />

                                {{-- ステータス --}}
                                <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">ステータス</th>

                                {{-- 担当者 --}}
                                <th class="px-4 py-2 border border-gray-200 dark:border-gray-600">担当者</th>

                                {{-- 作成日 --}}
                                <x-table.sortable-header
                                    label="作成日"
                                    column="created_at"
                                />
                            </tr>
                        </thead>

                        {{-- レコード --}}
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">

                                    {{-- 顧客名 --}}
                                    <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                                        <a href="{{ route('customers.show', $customer) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $customer->name }}
                                        </a>
                                    </td>

                                    {{-- メール --}}
                                    <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                                        {{ $customer->email ?: '未設定' }}
                                    </td>

                                    {{-- 電話番号 --}}
                                    <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                                        {{ $customer->phone ?: '未設定' }}
                                    </td>

                                    {{-- 会社名 --}}
                                    <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                                        {{ $customer->company_name ?: '未設定' }}
                                    </td>

                                    {{-- ステータス --}}
                                    <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                                        {{ $customer->status_label }}
                                    </td>

                                    {{-- 担当者 --}}
                                    <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                                        {{ $customer->assignedUser->name }}
                                    </td>

                                    {{-- 作成日 --}}
                                    <td class="px-4 py-2 border border-gray-200 dark:border-gray-600">
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
