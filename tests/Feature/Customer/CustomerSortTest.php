<?php

use App\Models\Customer;
use Tests\TestCase;

it('name で昇順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 並び順がバラバラの顧客を作成
    Customer::factory()->create(['name' => 'Cさん']);
    Customer::factory()->create(['name' => 'Aさん']);
    Customer::factory()->create(['name' => 'Bさん']);

    // 昇順ソートでアクセス
    $response = $this->get('/customers?sort=name&direction=asc');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // A → B → C の順で表示されることを確認
    $response->assertSeeInOrder(['Aさん', 'Bさん', 'Cさん']);
});

it('name で降順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 並び順がバラバラの顧客を3件作成
    Customer::factory()->create(['name' => 'Aさん']);
    Customer::factory()->create(['name' => 'Cさん']);
    Customer::factory()->create(['name' => 'Bさん']);

    // 降順ソートでアクセス
    $response = $this->get('/customers?sort=name&direction=desc');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // C → B → A の順で表示されることを確認
    $response->assertSeeInOrder(['Cさん', 'Bさん', 'Aさん']);
});
