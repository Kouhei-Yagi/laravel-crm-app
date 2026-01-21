<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            顧客一覧ページ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-max w-full border border-gray-300 dark:border-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-3 py-2 border">顧客名</th>
                                    <th class="px-3 py-2 border">フリガナ</th>
                                    <th class="px-3 py-2 border">メール</th>
                                    <th class="px-3 py-2 border">電話番号</th>
                                    <th class="px-3 py-2 border">会社名</th>
                                    <th class="px-3 py-2 border">部署</th>
                                    <th class="px-3 py-2 border">役職</th>
                                    <th class="px-3 py-2 border">住所</th>
                                    <th class="px-3 py-2 border">ステータス</th>
                                    <th class="px-3 py-2 border">ランク</th>
                                    <th class="px-3 py-2 border">担当者</th>
                                    <th class="px-3 py-2 border">作成日</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                        <td class="px-3 py-2 border">
                                            <a href="{{ route('customers.show', $customer) }}">{{ $customer->name }}</a>
                                        </td>
                                        <td class="px-3 py-2 border">{{ $customer->kana }}</td>
                                        <td class="px-3 py-2 border">{{ $customer->email }}</td>
                                        <td class="px-3 py-2 border">{{ $customer->phone }}</td>
                                        <td class="px-3 py-2 border">{{ $customer->company_name }}</td>
                                        <td class="px-3 py-2 border">{{ $customer->department }}</td>
                                        <td class="px-3 py-2 border">{{ $customer->position }}</td>
                                        <td class="px-3 py-2 border whitespace-normal break-words max-w-[240px]">
                                            {{ $customer->address }} {{ $customer->address_detail }}
                                        </td>
                                        <td class="px-3 py-2 border">{{ $customer->status }}</td>
                                        <td class="px-3 py-2 border">{{ $customer->rank }}</td>
                                        <td class="px-3 py-2 border">{{ optional($customer->user)->name }}</td>
                                        <td class="px-3 py-2 border">{{ $customer->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
