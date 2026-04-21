<?php

use App\Models\Customer;
use Tests\TestCase;

it('allows authenticated users to view the customer index page', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // Customer を3件作成
    $customers = Customer::factory()->count(3)->create();

    // /customers にアクセス
    $response = $this->get('/customers');

    // ステータスコード 200 を確認
    $response->assertOk();

    // 各 Customer の名前がレスポンスに含まれていることを確認
    foreach ($customers as $customer) {
        $response->assertSee($customer->name);
    }
});
