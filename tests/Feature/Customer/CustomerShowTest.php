<?php

use App\Models\Customer;
use Tests\TestCase;

it('ログインユーザーは顧客詳細画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客詳細画面にアクセス
    $response = $this->get("/customers/{$customer->id}");

    // 正常に表示されることを確認
    $response->assertOk();
});

it('未ログインユーザーは顧客詳細画面にアクセスできない', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 未ログイン状態で顧客詳細画面にアクセス
    $response = $this->get("/customers/{$customer->id}");

    // /login にリダイレクトされることを確認
    $response->assertRedirect('/login');
});
