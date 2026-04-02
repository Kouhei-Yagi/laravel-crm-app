<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            案件新規作成
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <p class="text-sm text-gray-800 dark:text-gray-200 mb-4">
                        <span class="text-red-500">*</span> は入力必須項目です。
                    </p>

                    <form action="{{ route('projects.store') }}" method="post" class="space-y-6">
                        @csrf

                        {{-- 基本情報 --}}
                        <h3 class="font-semibold text-lg">基本情報</h3>

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

                        {{-- ステータス・金額 --}}
                        <h3 class="font-semibold text-lg">案件ステータス</h3>

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

                        {{-- 日付 --}}
                        <h3 class="font-semibold text-lg">期間</h3>

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

                        {{-- メモ --}}
                        <h3 class="font-semibold text-lg">メモ</h3>

                        <div>
                            <textarea id="memo" name="memo"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-white dark:bg-gray-700 whitespace-pre-line"
                                placeholder="自由記述欄">{{ old('memo') }}</textarea>

                            @error('memo')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
