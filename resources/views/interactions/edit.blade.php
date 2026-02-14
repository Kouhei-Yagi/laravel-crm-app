<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            案件履歴編集ページ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('interactions.update', $interaction) }}" method="post" class="space-y-6">
                        @csrf
                        @method('patch')

                        {{-- 基本情報 --}}
                        <h3 class="font-semibold text-lg">基本情報</h3>

                        {{-- 対応日時 --}}
                        <div>
                            <label for="interacted_at" class="block mb-1">対応日時</label>
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
                            <label for="type" class="block mb-1">対応種別</label>
                            <select id="type" name="type"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">
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
                            <label for="content" class="block mb-1">内容</label>
                            <textarea id="content" name="content"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">{{ old('content', $interaction->content) }}</textarea>
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
                                       bg-white dark:bg-gray-700"
                                placeholder="自由記述欄">{{ old('memo', $interaction->memo) }}</textarea>
                            @error('memo')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 関連情報 --}}
                        <h3 class="font-semibold text-lg">関連情報</h3>

                        {{-- 案件名 --}}
                        <div>
                            <label for="project_id" class="block mb-1">案件名</label>
                            <select id="project_id" name="project_id"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" @selected(old('project_id', $interaction->project_id) == $project->id)>
                                        {{ $project->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 顧客名 --}}
                        <div>
                            <label for="customer_id" class="block mb-1">顧客名</label>
                            <select id="customer_id" name="customer_id"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id', $interaction->customer_id) == $customer->id)>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 担当者 --}}
                        <div>
                            <label for="assigned_user_id" class="block mb-1">担当者</label>
                            <select id="assigned_user_id" name="assigned_user_id"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('assigned_user_id', $interaction->assigned_user_id) == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_user_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ボタン --}}
                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                更新
                            </button>

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
