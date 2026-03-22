<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            案件履歴編集
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <p class="text-sm text-gray-800 dark:text-gray-200 mb-4">
                        <span class="text-red-500">*</span> は入力必須項目です。
                    </p>

                    <form action="{{ route('interactions.update', $interaction) }}" method="post" class="space-y-6">
                        @csrf
                        @method('patch')

                        {{-- 基本情報 --}}
                        <h3 class="font-semibold text-lg">基本情報</h3>

                        {{-- 対応日時 --}}
                        <div>
                            <label for="interacted_at" class="block mb-1">
                                対応日時 <span class="text-red-500">*</span>
                            </label>

                            <input type="datetime-local" id="interacted_at" name="interacted_at"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-white dark:bg-gray-700"
                                value="{{ old('interacted_at', $interaction->interacted_at->format('Y-m-d\TH:i')) }}">

                            @error('interacted_at')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 対応種別 --}}
                        <div>
                            <label for="type" class="block mb-1">
                                対応種別 <span class="text-red-500">*</span>
                            </label>

                            <select id="type" name="type"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-white dark:bg-gray-700">
                                <option value="">選択してください</option>
                                @foreach ($types as $key => $label)
                                    <option value="{{ $key }}" @selected(old('type', $interaction->type) == $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @error('type')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 内容 --}}
                        <div>
                            <label for="content" class="block mb-1">
                                内容 <span class="text-red-500">*</span>
                            </label>

                            <textarea id="content" name="content" placeholder="例：電話で仕様確認を実施"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-white dark:bg-gray-700 whitespace-pre-line">{{ old('content', $interaction->content) }}</textarea>

                            @error('content')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- メモ --}}
                        <div>
                            <label for="memo" class="block mb-1">メモ</label>

                            <textarea id="memo" name="memo"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-white dark:bg-gray-700 whitespace-pre-line"
                                placeholder="自由記述欄">{{ old('memo', $interaction->memo) }}</textarea>

                            @error('memo')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 関連情報 --}}
                        <h3 class="font-semibold text-lg">関連情報</h3>

                        {{-- 案件名 --}}
                        <div>
                            <label for="project_name" class="block mb-1">案件名</label>
                            <input type="text" id="project_name"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-gray-100 dark:bg-gray-600 cursor-not-allowed"
                                value="{{ $interaction->project->title ?? '案件なし（単発対応）' }}" disabled>
                        </div>

                        {{-- 顧客名 --}}
                        <div>
                            <label for="customer_name" class="block mb-1">顧客名</label>
                            <input type="text" id="customer_name"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-gray-100 dark:bg-gray-600 cursor-not-allowed"
                                value="{{ $interaction->customer->name }}" disabled>
                        </div>

                        {{-- ボタン --}}
                        <div class="flex items-center gap-4 mt-6">
                            <x-button.primary type="submit">
                                更新
                            </x-button.primary>

                            <a href="{{ route('interactions.show', $interaction) }}"
                                class="inline-block px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 dark:hover:bg-gray-400">
                                詳細ページに戻る
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
