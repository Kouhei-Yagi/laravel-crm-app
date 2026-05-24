<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight">
            案件新規作成
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

                    <form action="{{ route('projects.store') }}" method="post" class="space-y-10">
                        @csrf

                        {{-- 基本情報 --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">基本情報</h3>

                            {{-- 案件名 --}}
                            <x-input
                                name="title"
                                id="title"
                                label="案件名"
                                required
                                placeholder="例：ホームページ制作"
                            />

                            {{-- 顧客名 --}}
                            <x-select
                                name="customer_id"
                                id="customer_id"
                                label="顧客名"
                                required
                                :options="$customers"
                            />

                            {{-- 案件内容 --}}
                            <x-textarea
                                name="description"
                                id="description"
                                label="案件内容"
                                placeholder="例：要件の概要や依頼内容を入力してください"
                            />
                        </div>

                        {{-- ステータス・金額 --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">案件ステータス</h3>

                            {{-- ステータス --}}
                            <x-select
                                name="status"
                                id="status"
                                label="ステータス"
                                required
                                :options="$statuses"
                            />

                            {{-- 税抜金額 --}}
                            <x-input
                                name="amount"
                                id="amount"
                                type="number"
                                label="税抜金額"
                                placeholder="例：300000"
                                help="半角数字のみで入力してください。カンマ（,）は不要です。"
                            />
                        </div>

                        {{-- 期間 --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">期間</h3>

                            {{-- 開始日 --}}
                            <x-input
                                name="start_date"
                                id="start_date"
                                type="date"
                                label="開始日"
                            />

                            {{-- 終了日 --}}
                            <x-input
                                name="end_date"
                                id="end_date"
                                type="date"
                                label="終了日"
                            />
                        </div>

                        {{-- メモ --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">メモ</h3>

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

                            <x-button.secondary href="{{ route('projects.index') }}">
                                一覧に戻る
                            </x-button.secondary>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
