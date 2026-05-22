<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- タイトル --}}
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                顧客詳細
            </h2>

            {{-- ボタン --}}
            <div class="flex items-center gap-3">
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
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- フラッシュメッセージ --}}
                    <x-alert :message="session('success')" />

                    {{-- 詳細データ --}}
                    <table class="min-w-full w-full border border-gray-200 dark:border-gray-600 text-sm">
                        <tbody>

                            @foreach ([
                                '顧客名' => $customer->name,
                                'フリガナ' => $customer->kana ?: '未設定',
                                'メール' => $customer->email ?: '未設定',
                                '電話番号' => $customer->phone ?: '未設定',
                                '会社名' => $customer->company_name ?: '未設定',
                                '部署' => $customer->department ?: '未設定',
                                '役職' => $customer->position ?: '未設定',
                                '郵便番号' => $customer->postal_code ?: '未設定',
                                '住所' => trim(($customer->address ?: '未設定') . ' ' . $customer->address_detail),
                                'ステータス' => $customer->status_label,
                                'ランク' => $customer->rank_label,
                                '担当者' => $customer->assignedUser->name,
                                '作成日' => $customer->created_at->format('Y-m-d'),
                                '更新日' => $customer->updated_at->format('Y-m-d'),
                            ] as $label => $value)

                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                    <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 w-40 text-left">
                                        {{ $label }}
                                    </th>
                                    <td class="px-4 py-2 border border-gray-200 dark:border-gray-600 break-words">
                                        {{ $value }}
                                    </td>
                                </tr>

                            @endforeach

                            {{-- メモ欄だけ複数行対応 --}}
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 w-40 text-left">
                                    メモ
                                </th>
                                <td class="px-4 py-2 border border-gray-200 dark:border-gray-600 whitespace-pre-line break-words">{{ $customer->memo ?: '未設定' }}</td>
                            </tr>

                        </tbody>
                    </table>

                    {{-- ボタン --}}
                    <div class="flex items-center gap-4 mt-6">
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
