<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            顧客詳細ページ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table class="w-full border border-gray-300 dark:border-gray-700 text-sm">
                        <tbody>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border w-40">顧客名</th>
                                <td class="px-3 py-2 border">{{ $customer->name }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">フリガナ</th>
                                <td class="px-3 py-2 border">{{ $customer->kana }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">メール</th>
                                <td class="px-3 py-2 border">{{ $customer->email }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">電話番号</th>
                                <td class="px-3 py-2 border">{{ $customer->phone }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">会社名</th>
                                <td class="px-3 py-2 border">{{ $customer->company_name }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">部署</th>
                                <td class="px-3 py-2 border">{{ $customer->department }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">役職</th>
                                <td class="px-3 py-2 border">{{ $customer->position }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">住所</th>
                                <td class="px-3 py-2 border whitespace-normal break-words">
                                    {{ $customer->address }} {{ $customer->address_detail }}
                                </td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">ステータス</th>
                                <td class="px-3 py-2 border">{{ $customer->status }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">ランク</th>
                                <td class="px-3 py-2 border">{{ $customer->rank }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">担当者</th>
                                <td class="px-3 py-2 border">{{ optional($customer->user)->name }}</td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">作成日</th>
                                <td class="px-3 py-2 border">{{ $customer->created_at->format('Y-m-d') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('customers.index') }}" class="text-blue-600 hover:underline">
                            一覧に戻る
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
