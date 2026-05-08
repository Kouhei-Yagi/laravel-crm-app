<?php

use App\Models\Customer;
use App\Models\Interaction;
use Tests\TestCase;

it('ログインユーザーは対応履歴詳細画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // 対応履歴詳細画面にアクセス
    $response = $this->get(route('interactions.show', $interaction));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 対応履歴が表示されていることを確認
    $response->assertSeeText([
        $interaction->interacted_at->format('Y-m-d H:i'),
        Interaction::TYPE[$interaction->type],
        $interaction->content,
        $interaction->customer->name,
        $interaction->assignedUser->name,
    ]);
});
