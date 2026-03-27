<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            顧客新規登録
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <p class="text-sm text-gray-800 dark:text-gray-200 mb-4">
                        <span class="text-red-500">*</span> は入力必須項目です。
                    </p>

                    <form action="{{ route('customers.store') }}" method="post" class="space-y-6">
                        @csrf

                        {{-- 基本情報 --}}
                        <h3 class="font-semibold text-lg">基本情報</h3>

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
                            placeholder="例：example@example.com"
                        />

                        {{-- 電話番号 --}}
                        <x-input
                            name="phone"
                            id="phone"
                            type="tel"
                            placeholder="例：090-1234-5678"
                        />

                        {{-- 住所情報 --}}
                        <h3 class="font-semibold text-lg">住所情報</h3>

                        {{-- 郵便番号 --}}
                        <div>
                            <label for="postal_code" class="block mb-1">郵便番号</label>

                            <input type="text" id="postal_code" name="postal_code"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-white dark:bg-gray-700"
                                placeholder="例：1234567（「-」は省略してください。）" value="{{ old('postal_code') }}">

                            @error('postal_code')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 住所 --}}
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

                        {{-- 住所詳細 --}}
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

                        {{-- 会社名 --}}
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

                        {{-- 部署 --}}
                        <div>
                            <label for="department" class="block mb-1">部署</label>

                            <input type="text" id="department" name="department" placeholder="例：営業部"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-white dark:bg-gray-700"
                                value="{{ old('department') }}">

                            @error('department')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 役職 --}}
                        <div>
                            <label for="position" class="block mb-1">役職</label>

                            <input type="text" id="position" name="position" placeholder="例：課長"
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

                        {{-- ステータス --}}
                        <div>
                            <label for="status" class="block mb-1">
                                ステータス <span class="text-red-500">*</span>
                            </label>

                            <select id="status" name="status"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-white dark:bg-gray-700">
                                <option value="">選択してください</option>
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

                        {{-- ランク --}}
                        <div>
                            <label for="rank" class="block mb-1">
                                ランク <span class="text-red-500">*</span>
                            </label>

                            <select id="rank" name="rank"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                text-gray-900 dark:text-gray-100
                                bg-white dark:bg-gray-700">
                                <option value="">選択してください</option>
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
