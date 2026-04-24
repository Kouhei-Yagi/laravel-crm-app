<?php

use App\Http\Requests\CustomerStoreRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class);

it('顧客新規登録処理の name は必須である', function () {
    // 入力フォームから送信するデータ
    $data = [
        'name' => '',
        'status' => 'prospect',
        'rank' => 'A',
    ];

    // CustomerStoreRequest の rules を取得
    $request = new CustomerStoreRequest();
    $rules = $request->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('顧客新規登録処理の status は必須である', function () {
    // 入力フォームから送信するデータ
    $data = [
        'name' => '山田 太郎',
        'status' => '',
        'rank' => 'A',
    ];

    // CustomerStoreRequest の rules の取得
    $request = new CustomerStoreRequest();
    $rules = $request->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('顧客新規登録処理の rank は必須である', function () {
    // 入力フォームから送信するデータ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => '',
    ];

    // CustomerStoreRequest の rules を取得
    $request = new CustomerStoreRequest();
    $rules = $request->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('顧客新規登録処理の email は正しい形式ならバリデーションを通過する', function ($validEmail) {
    // 入力フォームからの送信データ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'email' => $validEmail,
    ];

    // CustomerStoreRequest の rules を取得
    $request = new CustomerStoreRequest();
    $rules = $request->rules();

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
]);

it('顧客新規登録処理の email は不正な形式だとバリデーションエラーになる', function ($invalidEmail) {
    // 入力フォームから送信するデータ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'email' => $invalidEmail,
    ];

    // CustomerStoreRequest の rules を取得
    $request = new CustomerStoreRequest();
    $rules = $request->rules();

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

it('顧客新規登録処理の phone は正しい形式なら通過する', function ($validPhone) {
    // 入力フォームからの送信データ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'phone' => $validPhone,
    ];

    // CustomerStoreRequest の rules を取得
    $request = new CustomerStoreRequest();
    $rules = $request->rules();

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

it('顧客新規登録処理の phone は不正な形式だとバリデーションエラーになる', function ($invalidPhone) {
    // 入力フォームからの送信データ
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'phone' => $invalidPhone,
    ];

    // CustomerStoreRequest の rules を取得
    $request = new CustomerStoreRequest();
    $rules = $request->rules();

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
    '090-1234-5678-9876-5432', // max:20 に違反
]);

it('顧客新規登録処理の postal_code は正しい形式なら通過する', function ($validPostalCode) {
    // 入力フォームからのデータ送信
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'postal_code' => $validPostalCode,
    ];

    // CustomerStoreRequest の rules を取得
    $request = new CustomerStoreRequest();
    $rules = $request->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーション通過を確認
    expect($validator->fails())->toBeFalse();

    // データプロバイダ機能で繰り返す
})->with([
    '1234567',  // 7桁の数字（基本形）
    '0000000',  // 0埋めもOK
    '9876543',  // ランダムな7桁
    '',         // nullable（空文字OK）
]);

it('顧客新規登録処理の postal_code は不正な形式だとバリデーションエラーになる', function ($invalidPostalCode) {
    // 入力フォームからのデータ送信
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'postal_code' => $invalidPostalCode,
    ];

    // CustomerStoreRequest の rules を取得
    $request = new CustomerStoreRequest();
    $rules = $request->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();

    // データプロバイダ機能で繰り返し
})->with([
    '123456',     // 6桁（短い）
    '12345678',   // 8桁（長い）
    '123-4567',   // ハイフン入り
    '１２３４５６７', // 全角数字
    '1234abc',    // 文字混じり
    '1234 567',   // スペース入り
    '1234_567',   // 記号（アンダースコア）
]);
