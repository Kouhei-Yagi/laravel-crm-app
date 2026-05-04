<?php

use App\Http\Requests\ProjectUpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('title がない場合はバリデーションエラーになる', function () {
    // 送信するデータ（案件編集フォームに入力されたデータ）を作成
    $data = [
        'title' => '',
        'status' => 'estimating',
    ];

    // バリデーションルールを取得
    $rules = (new ProjectUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('status がない場合はバリデーションエラーになる', function () {
    // 送信するデータ（案件編集フォームに入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'status' => '',
    ];

    // バリデーションルールを取得
    $rules = (new ProjectUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('amount が正しい形式の場合はバリデーションを通過する', function ($validAmount) {
    // 送信するデータ（案件編集フォームに入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'status' => 'estimating',
        'amount' => $validAmount,
    ];

    // バリデーションルールを取得
    $rules = (new ProjectUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションを通過することを確認
    expect($validator->fails())->toBeFalse();

    // データプロバイダ機能で繰り返す
})->with([
    null,
    '',
    0,
    1,
    '0',
    '1',
]);

it('amount が不正な形式の場合はバリデーションエラーになる', function ($invalidAmount) {
    // 送信するデータ（案件作成フォームから入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'status' => 'estimating',
        'amount' => $invalidAmount,
    ];

    // バリデーションルールを取得
    $rules = (new ProjectUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();

    // データプロバイダ機能で繰り返す
})->with([
    'abc',
    '100abc',
    '１２３',
    '1.5',
    1.5,
    '1,000',
    -1,
    -100,
]);
