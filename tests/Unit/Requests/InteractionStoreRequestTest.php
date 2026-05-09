<?php

use App\Http\Requests\InteractionStoreRequest;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('interacted_at がない場合はバリデーションエラーになる', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '',
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => $customer->id,
    ];

    // バリデーションルールを取得
    $rules = (new InteractionStoreRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーがあることを確認
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('interacted_at'))->toBeTrue();
});

it('type がない場合はバリデーションエラーになる', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => '',
        'content' => 'テスト',
        'customer_id' => $customer->id,
    ];

    // バリデーションルールを取得
    $rules = (new InteractionStoreRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーがあることを確認
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('type'))->toBeTrue();
});

it('content がない場合はバリデーションエラーになる', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => '',
        'customer_id' => $customer->id,
    ];

    // バリデーションルールを取得
    $rules = (new InteractionStoreRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーがあることを確認
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('content'))->toBeTrue();
});

it('customer_id がない場合はバリデーションエラーになる', function () {
    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => '',
    ];

    // バリデーションルールを取得
    $rules = (new InteractionStoreRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーがあることを確認
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('customer_id'))->toBeTrue();
});

it('interacted_at が正しい形式の場合はバリデーションを通過する', function ($validInteractedAt) {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => $validInteractedAt,
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => $customer->id,
    ];

    // バリデーションルールを取得
    $rules = (new InteractionStoreRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションを通過することを確認
    expect($validator->fails())->toBeFalse();
    expect($validator->errors()->has('interacted_at'))->toBeFalse();

    // データプロバイダ機能で繰り返す
})->with([
    'normal' => ['2026-01-01T12:00'],
    'end_of_year' => ['2026-12-31T23:59'],
    'zero_time' => ['2026-01-01T00:00'],
    'end_of_month' => ['2026-02-28T10:30'],
]);

it('interacted_at が不正な形式の場合はバリデーションエラーになる', function ($invalidInteractedAt) {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => $invalidInteractedAt,
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => $customer->id,
    ];

    // バリデーションルールを取得
    $rules = (new InteractionStoreRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーがあることを確認
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('interacted_at'))->toBeTrue();

    // データプロバイダ機能で繰り返す
})->with([
    'slash_format' => ['2026/01/01'],
    'space_format' => ['2026-01-01 12:00'],
    'date_only' => ['2026-01-01'],
    'time_only' => ['12:00'],
    'string' => ['abc'],
    'empty' => [''],
    'null' => [null],
    'invalid_month' => ['2026-13-01T12:00'],
    'invalid_hour' => ['2026-01-01T25:00'],
]);
