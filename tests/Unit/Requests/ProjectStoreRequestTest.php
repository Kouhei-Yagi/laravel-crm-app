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
