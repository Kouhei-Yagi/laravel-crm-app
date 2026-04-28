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

it('email で昇順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 並び順がバラバラの顧客を3件作成
    Customer::factory()->create(['email' => 'C@example.com']);
    Customer::factory()->create(['email' => 'A@example.com']);
    Customer::factory()->create(['email' => 'B@example.com']);

    // 昇順ソートでアクセス
    $response = $this->get('/customers?sort=email&direction=asc');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // A → B → C の順に表示されることを確認
    $response->assertSeeInOrder(['A@example.com', 'B@example.com', 'C@example.com']);
});


it('email で降順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 並び順がバラバラの顧客を3件作成
    Customer::factory()->create(['email' => 'A@example.com']);
    Customer::factory()->create(['email' => 'C@example.com']);
    Customer::factory()->create(['email' => 'B@example.com']);

    // 降順ソートでアクセス
    $response = $this->get('/customers?sort=email&direction=desc');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // C → B → A の順に表示されることを確認
    $response->assertSeeInOrder(['C@example.com', 'B@example.com', 'A@example.com']);
});

it('company_name で昇順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 並び順がバラバラの顧客を3件作成
    Customer::factory()->create(['company_name' => 'C株式会社']);
    Customer::factory()->create(['company_name' => 'A株式会社']);
    Customer::factory()->create(['company_name' => 'B株式会社']);

    // 昇順ソートでアクセス
    $response = $this->get('/customers?sort=company_name&direction=asc');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // A → B → C の順で表示されることを確認
    $response->assertSeeInOrder(['A株式会社', 'B株式会社', 'C株式会社']);
});

it('company_name で降順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 並び順がバラバラの顧客を3件作成
    Customer::factory()->create(['company_name' => 'A株式会社']);
    Customer::factory()->create(['company_name' => 'C株式会社']);
    Customer::factory()->create(['company_name' => 'B株式会社']);

    // 降順ソートでアクセス
    $response = $this->get('/customers?sort=company_name&direction=desc');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // C → B → A の順で表示されることを確認
    $response->assertSeeInOrder(['C株式会社', 'B株式会社', 'A株式会社']);
});

it('created_at で昇順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 並び順がバラバラの顧客を3件作成
    Customer::factory()->create(['created_at' => '2026-01-03 00:00:00']);
    Customer::factory()->create(['created_at' => '2026-01-01 00:00:00']);
    Customer::factory()->create(['created_at' => '2026-01-02 00:00:00']);

    // 昇順ソートでアクセス
    $response = $this->get('/customers?sort=created_at&direction=asc');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 01 → 02 → 03 の順で表示されることを確認
    $response->assertSeeInOrder(['2026-01-01', '2026-01-02', '2026-01-03']);
});

it('created_at で降順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 並び順がバラバラの顧客を3件作成
    Customer::factory()->create(['created_at' => '2026-01-01 00:00:00']);
    Customer::factory()->create(['created_at' => '2026-01-03 00:00:00']);
    Customer::factory()->create(['created_at' => '2026-01-02 00:00:00']);

    // 降順ソートでアクセス
    $response = $this->get('/customers?sort=created_at&direction=desc');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
    // 03 → 02 → 01 の順で表示されることを確認
    $response->assertSeeInOrder(['2026-01-03', '2026-01-02', '2026-01-01']);
});
