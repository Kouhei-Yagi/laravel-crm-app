<?php

use App\Models\Customer;
use App\Models\User;
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

    // '?keyword=090' で検索処理にアクセス
    $response = $this->get('/customers?keyword=090');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 検索条件にヒットしたデータが表示されることを確認
    $response->assertSee('090-1234-5678');
    // 検索条件にヒットしないデータは表示されないことを確認
    $response->assertDontSee('092-123-5678');
});

it('company_name の部分一致検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 検索にヒットする任意の顧客を作成
    Customer::factory()->create(['company_name' => '株式会社テスト']);
    // 検索にヒットしない任意の顧客を作成
    Customer::factory()->create(['company_name' => '有限会社ソリューション']);

    // '?keyword=株式会社' で検索処理にアクセス
    $response = $this->get('/customers?keyword=株式会社');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 検索条件にヒットしたデータが表示されることを確認
    $response->assertSee('株式会社テスト');
    // 検索条件にヒットしないデータは表示されないことを確認
    $response->assertDontSee('有限会社ソリューション');
});

it('status の絞り込み検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 検索にヒットする任意の顧客を作成
    Customer::factory()->create([
        'status' => 'prospect',
        'name' => '見込み 太郎',
    ]);
    // 検索にヒットしない任意の顧客を作成
    Customer::factory()->create([
        'status' => 'won',
        'name' => '成約 太郎',
    ]);

    // '?status=prospect' で検索処理にアクセス
    $response = $this->get('/customers?status=prospect');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 検索条件にヒットしたデータが表示されることを確認
    $response->assertSee('見込み 太郎');
    // 検索条件にヒットしないデータは表示されないことを確認
    $response->assertDontSee('成約 太郎');
});

it('assigned_user_id の絞り込み検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();
    // 他ユーザーを作成
    $otherUser = User::factory()->create();

    // 検索にヒットする任意の顧客を作成
    Customer::factory()->create([
        'assigned_user_id' => $user->id,
        'name' => '山田 太郎',
    ]);
    // 検索にヒットしない任意の顧客を作成
    Customer::factory()->create([
        'assigned_user_id' => $otherUser->id,
        'name' => '佐藤 花子',
    ]);

    // '?assigned_user_id={$user->id}' で検索処理にアクセス
    $response = $this->get("/customers?assigned_user_id={$user->id}");

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 検索条件にヒットしたデータが表示されることを確認
    $response->assertSee('山田 太郎');
    // 検索条件にヒットしないデータは表示されないことを確認
    $response->assertDontSee('佐藤 花子');
});

it('created_at の範囲検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 検索にヒットする任意の顧客を作成
    Customer::factory()->create(['created_at' => '2026-04-15 12:00:00']);
    // 検索にヒットしない任意の顧客を作成
    Customer::factory()->create(['created_at' => '2026-05-15 12:00:00']);

    // '?created_at_from=2026-04-01&created_at_to=2026-04-30'で検索処理にアクセス
    $response = $this->get('/customers?created_at_from=2026-04-01&created_at_to=2026-04-30');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 検索条件にヒットしたデータが表示されることを確認
    $response->assertSee('2026-04-15');
    // 検索条件にヒットしないデータは表示されないことを確認
    $response->assertDontSee('2026-05-15');
});

it('複数条件の AND 検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // 検索にヒットする任意の顧客を作成
    Customer::factory()->create([
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
        'assigned_user_id' => $user->id,
        'created_at' => '2026-04-15 12:00:00',
    ]);
    // 検索にヒットしない任意の顧客を作成
    Customer::factory()->create([
        'name' => '佐藤 花子'
    ]);

    // '?keyword=山田&status=prospect&rank=A&assigned_user_id={$user->id}&created_at_from=2026-04-01&created_at_to=2026-04-30' で検索処理にアクセス
    $response = $this->get("/customers?keyword=山田&status=prospect&rank=A&assigned_user_id={$user->id}&created_at_from=2026-04-01&created_at_to=2026-04-30");

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 検索条件にヒットしたデータが表示されることを確認
    $response->assertSee('山田 太郎');
    // 検索条件にヒットしないデータは表示されないことを確認
    $response->assertDontSee('佐藤 花子');
});

it('検索条件がない場合は全件表示される', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を3件作成
    $customers = Customer::factory()->count(3)->create();

    // 検索処理にアクセス
    $response = $this->get('/customers');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 全件表示されることを確認
    foreach ($customers as $customer) {
        $response->assertSee($customer->name);
    }
});
