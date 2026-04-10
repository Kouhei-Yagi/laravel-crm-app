{{--
<x-search.input> コンポーネント
検索フォーム用の1行入力欄（input type="text" / "number"）を共通化するための部品
--}}

@props([
    'label', // ラベルに表示する文字（例：キーワード）
    'name', // input の name 属性（例：keyword）
    'value' => '', // 初期値（request('xxx') を渡す想定）
    'placeholder' => '', // input の placeholder
    'type' => 'text', // input の種類（text / number）
])

<div>
    {{-- ラベル --}}
    <label for="{{ $name }}" class="block text-sm font-medium mb-1">
        {{ $label }}
    </label>

    {{-- 入力欄 --}}
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"

        {{-- Tailwind の共通スタイル（検索フォーム用） --}}
        class="w-full px-3 py-2 border border-gray-300 rounded-md
            dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
    >
</div>
