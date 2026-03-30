{{--
x-field コンポーネント
ラベル・必須マーク・help・エラーメッセージなど「入力欄の外側の枠」を共通化するための部品。
x-input / x-textarea / x-select などの“中身の入力欄” を包む役割を持つ。
--}}

@props([
    'name', // フィールド名（エラー判定に使用）
    'id' => null, // ラベルの for 属性に使う。未指定なら name を使う
    'label' => null, // ラベルの文言
    'required' => false, // 必須マーク（*）を付けるかどうか
    'help' => null, // 補足説明（help テキスト）
])

@php
    // id が指定されていなければ name を使う
    $id = $id ?? $name;

    // バリデーションエラーがあるかどうか
    $hasError = $errors->has($name);
@endphp

<div class="mb-4">

    {{-- ラベル（label 属性） --}}
    @if ($label)
        <label for="{{ $id }}" class="block mb-1">
            {{ $label }}
            {{-- 必須マーク（赤い *） --}}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    {{-- 入力欄（input/select/textarea など） --}}
    {{ $slot }}

    {{-- help（補足説明） --}}
    @if ($help)
        <p id="{{ $id }}-help" class="text-sm text-gray-500 mt-1">
            {{ $help }}
        </p>
    @endif

    {{-- エラーメッセージ --}}
    @error($name)
        <p id="{{ $id }}-error" class="text-red-600 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror

</div>
