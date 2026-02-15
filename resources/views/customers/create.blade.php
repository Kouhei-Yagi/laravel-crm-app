<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            顧客新規登録ページ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('customers.store') }}" method="post" class="space-y-6">
                        @csrf

                        {{-- 基本情報 --}}
                        <h3 class="font-semibold text-lg">基本情報</h3>

                        <div>
                            <label for="name" class="block mb-1">顧客名</label>
                            <input type="text" id="name" name="name"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                placeholder="例：山田太郎" value="{{ old('name') }}">

                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kana" class="block mb-1">フリガナ</label>
                            <input type="text" id="kana" name="kana"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                placeholder="例：ヤマダタロウ" value="{{ old('kana') }}">

                            @error('kana')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block mb-1">メール</label>
                            <input type="email" id="email" name="email"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                placeholder="例：example@example.com" value="{{ old('email') }}">

                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block mb-1">電話番号</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                placeholder="例：090-1234-5678" value="{{ old('phone') }}">

                            @error('phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 住所情報 --}}
                        <h3 class="font-semibold text-lg">住所情報</h3>

                        <div>
                            <label for="postal_code" class="block mb-1">郵便番号</label>
                            <input type="text" id="postal_code" name="postal_code"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                placeholder="例：123-4567" value="{{ old('postal_code') }}">

                            @error('postal_code')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block mb-1">住所</label>
                            <input type="text" id="address" name="address"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                placeholder="例：福岡県福岡市〇〇" value="{{ old('address') }}">

                            @error('address')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address_detail" class="block mb-1">住所詳細</label>
                            <input type="text" id="address_detail" name="address_detail"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                placeholder="例：マンション名・部屋番号など" value="{{ old('address_detail') }}">

                            @error('address_detail')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 会社情報 --}}
                        <h3 class="font-semibold text-lg">会社情報</h3>

                        <div>
                            <label for="company_name" class="block mb-1">会社名</label>
                            <input type="text" id="company_name" name="company_name"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                placeholder="例：株式会社サンプル" value="{{ old('company_name') }}">

                            @error('company_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="department" class="block mb-1">部署</label>
                            <input type="text" id="department" name="department"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                value="{{ old('department') }}">

                            @error('department')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position" class="block mb-1">役職</label>
                            <input type="text" id="position" name="position"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700"
                                value="{{ old('position') }}">

                            @error('position')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 管理情報 --}}
                        <h3 class="font-semibold text-lg">管理情報</h3>

                        <div>
                            <label for="status" class="block mb-1">ステータス</label>
                            <select id="status" name="status"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}" @selected(old('status') == $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="rank" class="block mb-1">ランク</label>
                            <select id="rank" name="rank"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       text-gray-900 dark:text-gray-100
                                       bg-white dark:bg-gray-700">
                                @foreach ($ranks as $key => $label)
                                    <option value="{{ $key }}" @selected(old('rank') == $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @error('rank')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

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

                            <a href="{{ route('customers.index') }}"
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
