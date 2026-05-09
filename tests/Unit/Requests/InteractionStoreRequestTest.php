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
    expect($validator->errors()->has('customer_id'))->toBeTrue();
});
