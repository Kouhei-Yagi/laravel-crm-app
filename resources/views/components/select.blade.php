{{--
x-select コンポーネント
プルダウン（select）を共通化するための部品
--}}

@props([
    'name',          // フィールド名（必須）
    'id' => null,    // 未指定なら name を使う
    'value' => null, // 初期値（old() と統合）
    'label' => null, // x-field に渡すラベル
    'required' => false, // 必須フラグ
    'help' => null,  // 補足説明
    'options' => [], // 選択肢（['key' => '表示名'] の形式）
])

@php
    // id が指定されていなければ name を使う
    $id = $id ?? $name;

    // old() があれば old を優先
    $selectedValue = old($name, $value);

    // バリデーションエラーがあるかどうか
    $hasError = $errors->has($name);

    // aria-describedby 用の ID を配列で準備
    $describedBy = [];

    if ($help) {
        $describedBy[] = $id . '-help';
    }

    if ($hasError) {
        $describedBy[] = $id . '-error';
    }

    $describedBy = implode(' ', $describedBy);
@endphp

{{-- x-field に枠（ラベル・help・エラー）を任せる --}}
<x-field :name="$name" :id="$id" :label="$label" :required="$required" :help="$help">

    {{-- select 要素 --}}
    <select
        name="{{ $name }}"
        id="{{ $id }}"

        @if ($hasError)
            aria-invalid="true"
        @endif

        @if ($describedBy)
            aria-describedby="{{ $describedBy }}"
        @endif

        {{ $attributes->class("
            w-full border-gray-300 rounded-md shadow-sm
            text-gray-900 dark:text-gray-100
            bg-white dark:bg-gray-700
        ") }}
    >

        {{-- 空の選択肢 --}}
        <option value="">選択してください</option>

        {{-- options をループ --}}
        @foreach ($options as $key => $label)
            <option value="{{ $key }}" @selected($selectedValue == $key)>
                {{ $label }}
            </option>
        @endforeach
    </select>

</x-field>
