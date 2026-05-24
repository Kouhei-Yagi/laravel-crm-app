<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight">
            対応履歴編集
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

                    <form action="{{ route('interactions.update', $interaction) }}" method="post" class="space-y-10">
                        @csrf
                        @method('patch')

                        {{-- 基本情報 --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                基本情報
                            </h3>

                            {{-- 対応日時 --}}
                            <x-input
                                name="interacted_at"
                                id="interacted_at"
                                type="datetime-local"
                                :value="$interaction->interacted_at?->format('Y-m-d\TH:i')"
                                label="対応日時"
                                required
                            />

                            {{-- 対応種別 --}}
                            <x-select
                                name="type"
                                id="type"
                                :value="$interaction->type"
                                label="対応種別"
                                required
                                :options="$types"
                            />

                            {{-- 内容 --}}
                            <x-textarea
                                name="content"
                                id="content"
                                :value="$interaction->content"
                                label="内容"
                                required
                                placeholder="例：電話で仕様確認を実施"
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
                                :value="$interaction->memo"
                                placeholder="自由記述欄"
                            />
                        </div>

                        {{-- 関連情報 --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                関連情報
                            </h3>

                            {{-- 案件名 --}}
                            <x-input
                                name="project_name"
                                id="project_name"
                                :value="$interaction->project?->title ?? '案件なし（単発対応）'"
                                label="案件名"
                                disabled
                            />

                            {{-- 顧客名 --}}
                            <x-input
                                name="customer_name"
                                id="customer_name"
                                :value="$interaction->customer?->name"
                                label="顧客名"
                                disabled
                            />
                        </div>

                        {{-- ボタン --}}
                        <div class="flex items-center gap-4 mt-6">
                            <x-button.primary type="submit">
                                更新
                            </x-button.primary>

                            <x-button.secondary href="{{ route('interactions.show', $interaction) }}">
                                詳細に戻る
                            </x-button.secondary>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
