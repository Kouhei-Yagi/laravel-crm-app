<?php

use App\Models\Customer;
use App\Models\Interaction;
use Tests\TestCase;

it('ログインユーザーは自分が担当する顧客に紐づく対応履歴の編集画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // 対応履歴編集画面にアクセス
    $response = $this->get(route('interactions.edit', $interaction));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 対応履歴が表示されることを確認
    $response->assertSee('value="' . $interaction->interacted_at->format('Y-m-d\TH:i') . '"', false);
    $response->assertSee('value="' . $interaction->customer->name . '"', false);
    $response->assertSeeText([
        Interaction::TYPE[$interaction->type],
        $interaction->content,
    ]);
});
