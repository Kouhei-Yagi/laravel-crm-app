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
    // 送信するデータ（案件編集フォームから入力されたデータ）を作成
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

it('start_date が正しい形式の場合はバリデーションを通過する', function ($validStartDate) {
    // 送信するデータ（案件編集フォームに入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'status' => 'estimating',
        'start_date' => $validStartDate,
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
    '2024-01-01',
    '2025-12-31',
    '2024/01/01',
    'January 1, 2024',
]);

it('start_date が不正な形式の場合はバリデーションエラーになる', function ($invalidStartDate) {
    // 送信するデータ（案件編集フォームに入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'status' => 'estimating',
        'start_date' => $invalidStartDate,
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
    '2024-13-01',
    '2024-00-10',
    '2024-01-32',
    '2024-02-30',
    '2024/13/01',
    12345,
]);

it('end_date が start_date よりも後の日付の場合はバリデーションを通過する', function () {
    // 送信するデータ（案件編集フォームから入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'status' => 'estimating',
        'start_date' => '2026-04-01',
        'end_date' => '2026-05-01',
    ];

    // バリデーションルールを取得
    $rules = (new ProjectUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションを通過することを確認
    expect($validator->fails())->toBeFalse();
});

it('end_date が start_date よりも前の日付の場合はバリデーションエラーになる', function () {
    // 送信するデータ（案件編集フォームから入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'status' => 'estimating',
        'start_date' => '2026-05-01',
        'end_date' => '2026-04-01',
    ];

    // バリデーションルールを取得
    $rules = (new ProjectUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});
