<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            顧客詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    <x-alert :message="session('success')" />

                    {{-- 詳細データ --}}
                    <table class="w-full border border-gray-300 dark:border-gray-700 text-sm">
                        <tbody>
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border w-40">顧客名</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->name }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">フリガナ</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->kana ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">メール</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->email ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">電話番号</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->phone ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">会社名</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->company_name ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">部署</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->department ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">役職</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->position ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">郵便番号</th>
                                <td class="px-3 py-2 border whitespace-normal break-words">
                                    {{ $customer->postal_code ?: '未設定' }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">住所</th>
                                <td class="px-3 py-2 border whitespace-normal break-words">
                                    {{ $customer->address ?: '未設定' }} {{ $customer->address_detail }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">ステータス</th>
                                <td class="px-3 py-2 border">
                                    {{ App\Models\Customer::STATUSES[$customer->status] }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">ランク</th>
                                <td class="px-3 py-2 border">
                                    {{ App\Models\Customer::RANKS[$customer->rank] }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">担当者</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->assignedUser->name }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">作成日</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->created_at->format('Y-m-d') }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">更新日</th>
                                <td class="px-3 py-2 border">
                                    {{ $customer->updated_at->format('Y-m-d') }}
                                </td>
                            </tr>

                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-3 py-2 border">メモ</th>
                                <td class="px-3 py-2 border whitespace-pre-line">{{ $customer->memo ?: '未設定' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- ボタン --}}
                    <div class="flex items-center gap-4 mt-6">
                        @can('update', $customer)
                            <x-button.primary href="{{ route('customers.edit', $customer) }}">
                                編集
                            </x-button.primary>
                        @endcan

                        @can('delete', $customer)
                            <form action="{{ route('customers.destroy', $customer) }}" method="post" class="inline-block">
                                @csrf
                                @method('delete')
                                <x-button.danger type="submit" onclick="return confirm('本当に削除しますか？')">
                                    削除
                                </x-button.danger>
                            </form>
                        @endcan

                        <x-button.secondary href="{{ route('customers.index') }}">
                            一覧に戻る
                        </x-button.secondary>
                    </div>

                    {{-- 案件一覧 --}}
                    <x-customer.project-list :projects="$projects"/>

                    {{-- 対応履歴一覧 --}}
                    <x-customer.interaction-list :interactions="$interactions"/>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
