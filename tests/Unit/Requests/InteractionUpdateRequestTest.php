<?php

use App\Http\Requests\InteractionUpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('interacted_at がない場合はバリデーションエラーになる', function () {
    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '',
        'type' => 'phone',
        'content' => 'テスト',
    ];

    // バリデーションルールを取得
    $rules = (new InteractionUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーがあることを確認
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('interacted_at'))->toBeTrue();
});

it('type がない場合はバリデーションエラーになる', function () {
    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => '',
        'content' => 'テスト',
    ];

    // バリデーションルールを取得
    $rules = (new InteractionUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーがあることを確認
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('type'))->toBeTrue();
});

it('content がない場合はバリデーションエラーになる', function () {
    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => '',
    ];

    // バリデーションルールを取得
    $rules = (new InteractionUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーがあることを確認
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('content'))->toBeTrue();
});
