<?php

use App\Models\Customer;
use Tests\TestCase;

it('顧客編集画面の表示テスト', function () {
    // ログインユーザーを作成してログイン
    $user = $this->loginUser();

    // ログインユーザーが作成した顧客
    $customer = Customer::factory()->create([
        'assigned_user_id' => $user->id
    ]);

    // /customers/{id}/edit にアクセス
    $response = $this->get("/customers/{$customer->id}/edit");

    // 編集画面が正常に表示されることを確認
    $response->assertOk();
});

it('customers テーブルの更新処理テスト', function () {
    // ログインユーザーを作成してログイン
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create([
        'assigned_user_id' => $user->id
    ]);

    // 送信するデータを作成
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
    ];

    // PATCH /customers/{id} にアクセス
    $response = $this->patch("/customers/{$customer->id}", $data);

    // 更新処理したことを確認
    $response->assertRedirect("/customers/{$customer->id}");

    // DB が更新されていることを確認
    $this->assertDatabaseHas('customers', [
        'id' => $customer->id,
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
    ]);
});

it('名前の顧客更新処理バリデーションエラーのテスト', function () {
    // ログインユーザーを作成してログイン
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create([
        'assigned_user_id' => $user->id
    ]);

    // 送信するデータを作成
    $data = [
        'name' => '',
        'status' => 'prospect',
        'rank' => 'A',
    ];

    // PATCH /customers/{id} にデータを持ってアクセス
    $response = $this->patch("/customers/{$customer->id}", $data);

    // バリデーションエラー → 302 リダイレクトを確認
    $response->assertStatus(302);

    // name にエラーメッセージがあることを確認
    $response->assertSessionHasErrors(['name']);
});

it('ステータスの顧客更新処理バリデーションエラーのテスト', function () {
    // ログインユーザーを作成してログイン
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create([
        'assigned_user_id' => $user->id
    ]);

    // 送信するデータを作成
    $data = [
        'name' => '山田 太郎',
        'status' => '',
        'rank' => 'A',
    ];

    // PATCH /customers/{id} にデータを持ってアクセス
    $response = $this->patch("/customers/{$customer->id}", $data);

    // バリデーションエラー → 302 リダイレクトを確認
    $response->assertStatus(302);

    // status にエラーメッセージがあることを確認
    $response->assertSessionHasErrors(['status']);
});

it('ランクの顧客更新処理バリデーションのテスト', function () {
    // ログインユーザーを作成してログイン
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create([
        'assigned_user_id' => $user->id
    ]);

    // 送信するデータを作成
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => '',
    ];

    // PATCH /customers/{id} にデータを持ってアクセス
    $response = $this->patch("/customers/{$customer->id}", $data);

    // バリデーションエラー → 302 リダイレクトを確認
    $response->assertStatus(302);

    // rank にエラーメッセージがあるか確認
    $response->assertSessionHasErrors(['rank']);
});
