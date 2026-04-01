<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            顧客編集
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <p class="text-sm text-gray-800 dark:text-gray-200 mb-4">
                        <span class="text-red-500">*</span> は入力必須項目です。
                    </p>

                    <form action="{{ route('customers.update', $customer) }}" method="post" class="space-y-6">
                        @csrf
                        @method('patch')

                        {{-- 基本情報 --}}
                        <h3 class="font-semibold text-lg">基本情報</h3>

                        {{-- 顧客名 --}}
                        <x-input
                            name="name"
                            id="name"
                            :value="$customer->name"
                            label="顧客名"
                            required
                            placeholder="例：山田 太郎"
                            help="姓と名の間に半角スペースを入れて入力してください。"
                        />

                        {{-- フリガナ --}}
                        <x-input
                            name="kana"
                            id="kana"
                            :value="$customer->kana"
                            label="フリガナ"
                            placeholder="例：ヤマダ タロウ"
                            help="性と名の間に半角スペースを入れて入力してください。"
                        />

                        {{-- メール --}}
                        <x-input
                            name="email"
                            id="email"
                            type="email"
                            :value="$customer->email"
                            label="メール"
                            placeholder="例：example@example.com"
                        />

                        {{-- 電話番号 --}}
                        <x-input
                            name="phone"
                            id="phone"
                            type="tel"
                            :value="$customer->phone"
                            label="電話番号"
                            placeholder="例：090-1234-5678"
                        />

                        {{-- 住所情報 --}}
                        <h3 class="font-semibold text-lg">住所情報</h3>

                        {{-- 郵便番号 --}}
                        <x-input
                            name="postal_code"
                            id="postal_code"
                            :value="$customer->postal_code"
                            label="郵便番号"
                            placeholder="例：1234567"
                            help="半角数字7桁で入力してください。"
                        />

                        {{-- 住所 --}}
                        <x-input
                            name="address"
                            id="address"
                            :value="$customer->address"
                            label="住所"
                            placeholder="例：福岡県福岡市〇〇"
                        />

                        {{-- 住所詳細 --}}
                        <x-input
                            name="address_detail"
                            id="address_detail"
                            :value="$customer->address_detail"
                            label="住所詳細"
                            placeholder="例：〇〇マンション101号室"
                            help="建物名・部屋番号などがある場合は入力してください。"
                        />

                        {{-- 会社情報 --}}
                        <h3 class="font-semibold text-lg">会社情報</h3>

                        {{-- 会社名 --}}
                        <x-input
                            name="company_name"
                            id="company_name"
                            :value="$customer->company_name"
                            label="会社名"
                            placeholder="例：株式会社サンプル"
                        />

                        {{-- 部署 --}}
                        <x-input
                            name="department"
                            id="department"
                            :value="$customer->department"
                            label="部署"
                            placeholder="例：営業部"
                        />

                        {{-- 役職 --}}
                        <x-input
                            name="position"
                            id="position"
                            :value="$customer->position"
                            label="役職"
                            placeholder="例：課長"
                        />

                        {{-- 管理情報 --}}
                        <h3 class="font-semibold text-lg">管理情報</h3>

                        {{-- ステータス --}}
                        <x-select
                            name="status"
                            id="status"
                            :value="$customer->status"
                            label="ステータス"
                            required
                            :options="$statuses"
                        />

                        {{-- ランク --}}
                        <x-select
                            name="rank"
                            id="rank"
                            :value="$customer->rank"
                            label="ランク"
                            required
                            :options="$ranks"
                        />

                        {{-- メモ --}}
                        <h3 class="font-semibold text-lg">メモ</h3>

                        <x-textarea
                            name="memo"
                            id="memo"
                            :value="$customer->memo"
                            placeholder="自由記述欄"
                        />

                        {{-- ボタン --}}
                        <div class="flex items-center gap-4 mt-6">
                            <x-button.primary type="submit">
                                更新
                            </x-button.primary>

                            <x-button.secondary href="{{ route('customers.show', $customer) }}">
                                詳細に戻る
                            </x-button.secondary>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
