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
