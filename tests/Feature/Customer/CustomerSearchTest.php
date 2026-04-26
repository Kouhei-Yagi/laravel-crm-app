<?php

use App\Models\Customer;
use Tests\TestCase;

it('name の部分一致検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    Customer::factory()->create(['name' => '山田 太郎']);
    Customer::factory()->create(['name' => '佐藤 花子']);

    // '?name=山田' で検索処理にアクセス
    $response = $this->get('/customers?keyword=山田');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 名前が表示されることを確認
    $response->assertSee('山田 太郎');

    // 名前が表示されないことを確認
    $response->assertDontSee('佐藤 花子');
});
