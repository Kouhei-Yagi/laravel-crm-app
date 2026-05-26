{{--
x-input コンポーネント
1行入力欄（input type="text" など）を共通化するための部品
--}}

@props([
    'name', // フィールド名（必須）
    'id' => null, // 未指定なら name を使う
    'type' => 'text', // input の種類（text, email など）
    'value' => null, // 初期値（old() と統合）
    'label' => null, // x-field に渡すラベル
    'required' => false, // 必須フラグ
    'help' => null, // 補足説明
    'placeholder' => null, // input の placeholder
    'disabled' => false, // 入力欄を無効化（編集不可）にする
])

@php
    // id が指定されていなければ name を使う
    $id = $id ?? $name;

    // old() があれば old を優先し、なければ value を使う
    $inputValue = old($name, $value);

    // バリデーションエラーがあるかどうか
    $hasError = $errors->has($name);

    // aria-describedby 用の ID を配列で準備
    $describedBy = [];

    // help があれば help の ID を追加
    if ($help) {
        $describedBy[] = $id . '-help';
    }

    // エラーがあれば error の ID を追加
    if ($hasError) {
        $describedBy[] = $id . '-error';
    }

    // 配列をスペース区切りで結合（HTML の仕様）
    $describedBy = implode(' ', $describedBy);
@endphp

{{-- x-field に枠（ラベル・help・エラー）を任せる --}}
<x-field :name="$name" :id="$id" :label="$label" :required="$required" :help="$help">

    {{-- input 要素 --}}
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $inputValue }}"
        placeholder="{{ $placeholder }}"

        {{-- エラー時は aria-invalid を付ける --}}
        @if ($hasError)
            aria-invalid="true"
        @endif

        {{-- help や error がある場合は aria-describedby を付ける --}}
        @if ($describedBy)
            aria-describedby="{{ $describedBy }}"
        @endif

        {{-- disabled が true の場合は input を無効化 --}}
        @if ($disabled)
            disabled
        @endif

        {{-- Tailwind のスタイルを適用 --}}
        {{ $attributes->class([
            // 共通スタイル
            "w-full border-gray-300 rounded-md shadow-sm text-gray-900 dark:text-gray-100",

            // 通常時の背景
            "bg-white dark:bg-gray-700" => ! $disabled,

            // disabled 時の背景・カーソル
            "bg-gray-100 dark:bg-gray-600 cursor-not-allowed" => $disabled,
        ]) }}
    />

</x-field>
