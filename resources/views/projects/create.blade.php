<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            案件新規作成ページ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('projects.store') }}" method="post" class="space-y-6">
                        @csrf

                        {{-- 基本情報 --}}
                        <h3 class="font-semibold text-lg">基本情報</h3>

                        <div>
                            <label for="title" class="block mb-1">案件名</label>
                            <input type="text" id="title" name="title"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                value="{{ old('title') }}">

                            @error('title')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="customer_id" class="block mb-1">顧客名</label>
                            <select id="customer_id" name="customer_id"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('customer_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block mb-1">案件内容</label>
                            <textarea id="description" name="description"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">{{ old('description') }}</textarea>

                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ステータス・金額 --}}
                        <h3 class="font-semibold text-lg">案件ステータス</h3>

                        <div>
                            <label for="status" class="block mb-1">ステータス</label>
                            <select id="status" name="status"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status') == $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="block mb-1">税抜金額</label>
                            <input type="number" id="amount" name="amount"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                value="{{ old('amount') }}">

                            @error('amount')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 日付 --}}
                        <h3 class="font-semibold text-lg">期間</h3>

                        <div>
                            <label for="start_date" class="block mb-1">開始日</label>
                            <input type="date" id="start_date" name="start_date"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                value="{{ old('start_date') }}">

                            @error('start_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block mb-1">終了日</label>
                            <input type="date" id="end_date" name="end_date"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                value="{{ old('end_date') }}">

                            @error('end_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 担当者 --}}
                        <h3 class="font-semibold text-lg">担当者</h3>

                        <div>
                            <label for="assigned_user_id" class="block mb-1">担当者</label>
                            <select id="assigned_user_id" name="assigned_user_id"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">
                                @foreach ($assignedUsers as $assignedUser)
                                    <option value="{{ $assignedUser->id }}" @selected(old('assigned_user_id') == $assignedUser->id)>
                                        {{ $assignedUser->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('assigned_user_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- メモ --}}
                        <h3 class="font-semibold text-lg">メモ</h3>

                        <div>
                            <textarea id="memo" name="memo"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                placeholder="自由記述欄">{{ old('memo') }}</textarea>

                            @error('memo')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ボタン --}}
                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                新規登録
                            </button>

                            <a href="{{ route('projects.index') }}"
                                class="inline-block px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 dark:hover:bg-gray-400">
                                一覧に戻る
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
