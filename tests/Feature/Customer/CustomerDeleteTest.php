<?php

use App\Models\Customer;
use App\Models\User;
use Tests\TestCase;

it('ログインユーザーは自分の担当する顧客を削除できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create([
        'assigned_user_id' => $user->id,
    ]);

    // 削除処理にアクセス
    $response = $this->delete("/customers/{$customer->id}");

    // 一覧画面にリダイレクトすることを確認
    $response->assertRedirect('/customers');

    // DB から顧客が論理削除されていることを確認
    $this->assertSoftDeleted('customers', [
        'id' => $customer->id
    ]);
});

it('未ログインユーザーは顧客削除処理ができない', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 未ログイン状態で削除処理にアクセス
    $response = $this->delete("/customers/{$customer->id}");

    // /login にリダイレクトされることを確認
    $response->assertRedirect('/login');
});

it('ログインユーザー以外のユーザーが作成した顧客は削除できない', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 別ユーザーを作成
    $otherUser = User::factory()->create();

    // 別ユーザーで顧客を作成
    $customer = Customer::factory()->create([
        'assigned_user_id' => $otherUser->id
    ]);

    // ログインユーザーで別ユーザーの顧客の削除処理にアクセス
    $response = $this->delete("/customers/{$customer->id}");

    // 403 Forbidden が返ることを確認
    $response->assertStatus(403);
});
