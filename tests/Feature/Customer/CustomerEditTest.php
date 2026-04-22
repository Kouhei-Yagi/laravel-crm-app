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
