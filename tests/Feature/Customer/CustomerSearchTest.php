<?php

use App\Models\Customer;
use Tests\TestCase;

it('name の部分一致検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 検索にヒットする任意の顧客を作成
    Customer::factory()->create(['name' => '山田 太郎']);
    // 検索にヒットしない任意の顧客を作成
    Customer::factory()->create(['name' => '佐藤 花子']);

    // '?keyword=山田' で検索処理にアクセス
    $response = $this->get('/customers?keyword=山田');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 名前が表示されることを確認
    $response->assertSee('山田 太郎');
    // 名前が表示されないことを確認
    $response->assertDontSee('佐藤 花子');
});

it('email の部分一致・完全一致検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 検索にヒットする任意の顧客を作成
    Customer::factory()->create(['email' => 'test@example.com']);
    // 検索にヒットしない任意の顧客を作成
    Customer::factory()->create(['email' => 'other@example.com']);

    // 完全一致
    // '?keyword=test@example.com' で検索処理にアクセス
    $response = $this->get('/customers?keyword=test@example.com');
    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 検索条件にヒットしたデータが表示されることを確認
    $response->assertSee('test@example.com');
    // 検索条件にヒットしないデータは表示されないことを確認
    $response->assertDontSee('other@example.com');

    // 部分一致
    // '?keyword=@example.com' で検索処理にアクセス
    $response = $this->get('/customers?keyword=@example.com');
    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 検索条件にヒットしたデータが表示されることを確認
    $response->assertSee('test@example.com');
    $response->assertSee('other@example.com');
});

it('phone の部分一致検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 検索にヒットする任意の顧客を作成
    Customer::factory()->create(['phone' => '090-1234-5678']);
    // 検索にヒットしない任意の顧客を作成
    Customer::factory()->create(['phone' => '092-123-5678']);

    // '?keyword=090' 検索処理にアクセス
    $response = $this->get('/customers?keyword=090');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 検索条件にヒットしたデータが表示されることを確認
    $response->assertSee('090-1234-5678');
    // 検索条件にヒットしないデータは表示されないことを確認
    $response->assertDontSee('092-123-5678');
});
