<?php

use App\Http\Requests\CustomerUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class);

it('name は必須である', function () {
    // 入力フォームから送信するデータ
    $data = [
        'name' => '',
        'status' => 'prospect',
        'rank' => 'A',
    ];

    // CustomerUpdateRequest の rules を取得
    $rules = (new CustomerUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('status は必須である', function () {
    // 入力フォームから送信するデータ
    $data = [
        'name' => '山田 太郎',
        'status' => '',
        'rank' => 'A',
    ];

    // CustomerUpdateRequest の rules の取得
    $rules = (new CustomerUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('rank は必須である', function () {
    // 入力フォームから送信するデータ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => '',
    ];

    // CustomerUpdateRequest の rules を取得
    $rules = (new CustomerUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('email は正しい形式ならバリデーションを通過する', function ($validEmail) {
    // 入力フォームからの送信データ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'email' => $validEmail,
    ];

    // CustomerUpdateRequest の rules を取得
    $rules = (new CustomerUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーション通過を確認
    expect($validator->fails())->toBeFalse();

    // データプロバイダ機能で繰り返す
})->with([
    'test@example.com',
    'user.name@example.co.jp',
    'user_name@example.net',
    'user-name@example.org',
    '',  // nullable（空文字OK）
]);

it('email は不正な形式だとバリデーションエラーになる', function ($invalidEmail) {
    // 入力フォームから送信するデータ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'email' => $invalidEmail,
    ];

    // CustomerUpdateRequest の rules を取得
    $rules = (new CustomerUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();

    // データプロバイダ機能で繰り返す
})->with([
    'test',              // @なし
    'test@',             // ドメインなし
    '@example.com',      // ローカルパートなし
    'test@@example.com', // @が2つ
    'test@ example.com', // スペース入り
]);
