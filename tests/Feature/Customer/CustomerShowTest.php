<?php

use App\Models\Customer;
use Tests\TestCase;

it('ログインユーザーは顧客詳細画面を表示できる', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // GET /customers/{id} にアクセス
    $response = $this->get("/customers/{$customer->id}");

    // 正常に表示されることを確認
    $response->assertOk();
});
