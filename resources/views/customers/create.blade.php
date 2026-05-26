<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight">
            顧客新規登録
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 shadow-sm rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- 「必須」の説明 --}}
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">
                        <span class="text-red-500">*</span> は入力必須項目です。
                    </p>

                    <form action="{{ route('customers.store') }}" method="post" class="space-y-6">
                        @csrf

                        {{-- 基本情報 --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">基本情報
                            </h3>

                            {{-- 顧客名 --}}
                            <x-input
                                name="name"
                                id="name"
                                label="顧客名"
                                required
                                placeholder="例：山田 太郎"
                                help="姓と名の間に半角スペースを入れて入力してください。"
                            />

                            {{-- フリガナ --}}
                            <x-input
                                name="kana"
                                id="kana"
                                label="フリガナ"
                                placeholder="例：ヤマダ タロウ"
                                help="性と名の間に半角スペースを入れて入力してください。"
                            />

                            {{-- メール --}}
                            <x-input
                                name="email"
                                id="email"
                                type="email"
                                label="メール"
                                placeholder="例：example@example.com"
                            />

                            {{-- 電話番号 --}}
                            <x-input
                                name="phone"
                                id="phone"
                                type="tel"
                                label="電話番号"
                                placeholder="例：090-1234-5678"
                            />
                        </div>

                        {{-- 住所情報 --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                住所情報
                            </h3>

                            {{-- 郵便番号 --}}
                            <x-input
                                name="postal_code"
                                id="postal_code"
                                label="郵便番号"
                                placeholder="例：12334567"
                                help="半角数字7桁で入力してください。"
                            />

                            {{-- 住所 --}}
                            <x-input
                                name="address"
                                id="address"
                                label="住所"
                                placeholder="例：福岡県福岡市〇〇"
                            />

                            {{-- 住所詳細 --}}
                            <x-input
                                name="address_detail"
                                id="address_detail"
                                label="住所詳細"
                                placeholder="例：1-2-3 〇〇マンション101号室"
                                help="番地・建物名・部屋番号を入力してください。"
                            />
                        </div>

                        {{-- 会社情報 --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                会社情報
                            </h3>

                            {{-- 会社名 --}}
                            <x-input
                                name="company_name"
                                id="company_name"
                                label="会社名"
                                placeholder="例：株式会社サンプル"
                            />

                            {{-- 部署 --}}
                            <x-input
                                name="department"
                                id="department"
                                label="部署名"
                                placeholder="例：営業部"
                            />

                            {{-- 役職 --}}
                            <x-input
                                name="position"
                                id="position"
                                label="役職"
                                placeholder="例：課長"
                            />
                        </div>

                        {{-- 管理情報 --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                管理情報
                            </h3>

                            {{-- ステータス --}}
                            <x-select
                                name="status"
                                id="status"
                                label="ステータス"
                                required
                                :options="$statuses"
                            />

                            {{-- ランク --}}
                            <x-select
                                name="rank"
                                id="rank"
                                label="ランク"
                                required
                                :options="$ranks"
                            />
                        </div>

                        {{-- メモ --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                メモ
                            </h3>

                            <x-textarea
                                name="memo"
                                id="memo"
                                placeholder="自由記述欄"
                            />
                        </div>

                        {{-- ボタン --}}
                        <div class="flex items-center gap-4 mt-6">
                            <x-button.primary type="submit">
                                新規登録
                            </x-button.primary>

                            <x-button.secondary href="{{ route('customers.index') }}">
                                一覧に戻る
                            </x-button.secondary>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
