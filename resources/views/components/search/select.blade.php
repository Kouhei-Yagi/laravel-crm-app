{{--
<x-search.select> コンポーネント
検索フォーム用のセレクトボックス（select）を共通化するための部品
--}}

@props([
    'name',  // select の name 属性（例：status）
    'label' => '', // ラベル（空なら非表示）
    'value' => '', // 初期値（request('xxx') を渡す想定）
    'options' => [], // ['key' => '表示名'] の形式で渡す
    'emptyLabel' => '未選択', // 最初の空選択肢の表示
])

<div>
    {{-- ラベル（空文字なら表示しない） --}}
    @if ($label !== '')
        <label for="{{ $name }}" class="block text-sm font-medium mb-1">
            {{ $label }}
        </label>
    @endif

    {{-- セレクトボックス --}}
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        class="w-full px-3 py-2 h-10 border border-gray-200 rounded-md
            text-gray-700 placeholder-gray-400
            dark:bg-gray-500 dark:border-gray-400 dark:text-gray-100 dark:placeholder-gray-300"
    >

        {{-- 空の選択肢 --}}
        <option value="">{{ $emptyLabel }}</option>

        {{-- options をループ --}}
        @foreach ($options as $key => $text)
            <option value="{{ $key }}" @selected($value == $key)>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>
