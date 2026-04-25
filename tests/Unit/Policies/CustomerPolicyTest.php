<?php

use App\Models\Customer;
use App\Models\User;
use App\Policies\CustomerPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class, TestCase::class);

it('一覧画面はログインユーザーなら見れる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // Policy の viewAny() を呼び出す
    $result = (new CustomerPolicy())->viewAny($user);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('詳細画面はログインユーザーなら見れる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // Policy の view を呼び出す
    $result = (new CustomerPolicy())->view($user, $customer);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('新規作成画面はログインユーザーなら見れる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // Policy の create を呼び出す
    $result = (new CustomerPolicy())->create($user);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});
