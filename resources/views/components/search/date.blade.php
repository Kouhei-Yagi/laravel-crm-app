{{--
<x-search.date> コンポーネント
検索フォーム用の日付範囲入力（from/to）を共通化するための部品
--}}

@props([
    'label', // ラベル（例：作成日）
    'name', // ベースとなる name（例：created_at）
    'from' => '', // 初期値（request('created_at_from') を渡す想定）
    'to' => '', // 初期値（request('created_at_to') を渡す想定）
])

@php
    // 日付入力欄の共通クラス
    $inputClass = 'w-40 px-3 py-2 border border-gray-300 rounded-md
                dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100';

    // 実際の name 属性（from/to）を生成
    $nameFrom = $name . '_from';
    $nameTo   = $name . '_to';
@endphp

<div>
    {{-- ラベル（空文字なら表示しない） --}}
    @if ($label)
        <label class="block text-sm font-medium mb-1">
            {{ $label }}
        </label>
    @endif

    {{-- 日付範囲入力（from/to） --}}
    <div class="flex items-center gap-2">
        <input
            type="date"
            name="{{ $nameFrom }}"
            value="{{ $from }}"
            class="{{ $inputClass }}"
        >

        <span class="text-gray-600 dark:text-gray-300">〜</span>

        <input
            type="date"
            name="{{ $nameTo }}"
            value="{{ $to }}"
            class="{{ $inputClass }}"
        >
    </div>
</div>
