<?php

use App\Http\Requests\ProjectStoreRequest;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('title がない場合はバリデーションエラーになる', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 送信するデータ（案件作成フォームから入力されるデータ）を作成
    $data = [
        'title' => '',
        'customer_id' => $customer->id,
        'status' => 'estimating',
    ];

    // バリデーションルールの取得
    $rules = (new ProjectStoreRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('customer_id がない場合はバリデーションエラーになる', function () {
    // 送信するデータ（案件作成フォームから入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'customer_id' => '',
        'status' => 'estimating',
    ];

    // バリデーションルールを取得
    $rules = (new ProjectStoreRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('status がない場合はバリデーションエラーになる', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 送信するデータ（案件作成フォームから入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'customer_id' => $customer->id,
        'status' => '',
    ];

    // バリデーションルールを取得
    $rules = (new ProjectStoreRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('amount が正しい形式の場合はバリデーションを通過する', function ($validAmount) {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 送信するデータ（案件作成フォームから入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'customer_id' => $customer->id,
        'status' => 'estimating',
        'amount' => $validAmount,
    ];

    // バリデーションルールを取得
    $rules = (new ProjectStoreRequest())->rules();

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
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 送信するデータ（案件作成フォームから入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'customer_id' => $customer->id,
        'status' => 'estimating',
        'amount' => $invalidAmount,
    ];

    // バリデーションルールを取得
    $rules = (new ProjectStoreRequest())->rules();

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
