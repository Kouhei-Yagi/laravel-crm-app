<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            案件編集
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <p class="text-sm text-gray-800 dark:text-gray-200 mb-4">
                        <span class="text-red-500">*</span> は入力必須項目です。
                    </p>

                    <form action="{{ route('projects.update', $project) }}" method="post" class="space-y-6">
                        @csrf
                        @method('patch')

                        {{-- 基本情報 --}}
                        <h3 class="font-semibold text-lg">基本情報</h3>

                        {{-- 案件名 --}}
                        <x-input
                            name="title"
                            id="title"
                            :value="$project->title"
                            label="案件名"
                            required
                            placeholder="例：ホームページ制作"
                        />

                        {{-- 顧客名 --}}
                        <x-input
                            name="customer_name"
                            id="customer_name"
                            :value="$project->customer->name"
                            label="顧客名"
                            disabled
                        />

                        {{-- 案件内容 --}}
                        <x-textarea
                            name="description"
                            id="description"
                            :value="$project->description"
                            label="案件内容"
                            placeholder="例：要件の概要や依頼内容を入力してください"
                        />

                        {{-- ステータス・金額 --}}
                        <h3 class="font-semibold text-lg">案件ステータス</h3>

                        {{-- ステータス --}}
                        <x-select
                            name="status"
                            id="status"
                            :value="$project->status"
                            required
                            label="ステータス"
                            :options="$statuses"
                        />

                        {{-- 税抜金額 --}}
                        <x-input
                            name="amount"
                            id="amount"
                            type="number"
                            :value="$project->amount"
                            label="税抜金額"
                            placeholder="例：300000"
                            help="半角数字のみで入力してください。カンマ（,）は不要です。"
                        />

                        {{-- 期間 --}}
                        <h3 class="font-semibold text-lg">期間</h3>

                        {{-- 開始日 --}}
                        <x-input
                            name="start_date"
                            id="start_date"
                            type="date"
                            :value="$project->start_date?->format('Y-m-d')"
                            label="開始日"
                        />

                        {{-- 終了日 --}}
                        <x-input
                            name="end_date"
                            id="end_date"
                            type="date"
                            :value="$project->end_date?->format('Y-m-d')"
                            label="終了日"
                        />

                        {{-- メモ --}}
                        <h3 class="font-semibold text-lg">メモ</h3>

                        <x-textarea
                            name="memo"
                            id="memo"
                            :value="$project->memo"
                            placeholder="自由記述欄"
                        />

                        {{-- ボタン --}}
                        <div class="flex items-center gap-4 mt-6">
                            <x-button.primary type="submit">
                                更新
                            </x-button.primary>

                            <x-button.secondary href="{{ route('projects.show', $project) }}">
                                詳細に戻る
                            </x-button.secondary>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
