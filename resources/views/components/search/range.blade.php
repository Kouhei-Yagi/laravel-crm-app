{{--
<x-search.range> コンポーネント
検索フォーム用の数値範囲入力（from/to）を共通化するための部品
--}}

@props([
    'label',
    'name', // ベース名（例：amount）
    'from' => '', // request('amount_from')
    'to' => '', // request('amount_to')
])

@php
    // 数値入力欄の共通クラス
    $inputClass = 'w-32 px-3 py-2 h-10 border border-gray-200 rounded-md
                dark:bg-gray-500 dark:border-gray-400 dark:text-gray-100';

    // 実際の name 属性（from/to）を生成
    $nameFrom = $name . '_from';
    $nameTo   = $name . '_to';
@endphp

<div>
    {{-- ラベル --}}
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            {{ $label }}
        </label>
    @endif

    {{-- 数値範囲入力（from/to） --}}
    <div class="flex items-center gap-2">
        <input
            type="number"
            name="{{ $nameFrom }}"
            value="{{ $from }}"
            min="0"
            class="{{ $inputClass }}"
        >

        <span class="text-gray-600 dark:text-gray-300">〜</span>

        <input
            type="number"
            name="{{ $nameTo }}"
            value="{{ $to }}"
            min="0"
            class="{{ $inputClass }}"
        >
    </div>
</div>
