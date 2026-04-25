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

it('phone は正しい形式なら通過する', function ($validPhone) {
    // 入力フォームからの送信データ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'phone' => $validPhone,
    ];

    // CustomerUpdateRequest の rules を取得
    $rules = (new CustomerUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーション通過を確認
    expect($validator->fails())->toBeFalse();

    // データプロバイダ機能で繰り返す
})->with([
    '09012345678',        // 数字のみ
    '092-123-4567',       // 一般的な固定電話
    '090-1234-5678',       // 携帯電話の番号
    '0120-123-456',       // フリーダイヤル
    '12345678901234567890', // 20文字ギリギリ
    '',                   // nullable（空文字OK）
]);

it('phone は不正な形式だとバリデーションエラーになる', function ($invalidPhone) {
    // 入力フォームからの送信データ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'phone' => $invalidPhone,
    ];

    // CustomerUpdateRequest の rules を取得
    $rules = (new CustomerUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();

    // データプロバイダ機能で繰り返す
})->with([
    '090-1234-5678a',     // アルファベット
    '090-1234-5678 ',     // スペース
    '090_1234_5678',      // アンダースコア
    '090/1234/5678',      // スラッシュ
    '090+1234+5678',      // プラス記号
    '123456789012345678901', // 21文字（確実に max:20 に違反）
]);
