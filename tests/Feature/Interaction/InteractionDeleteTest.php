<?php

use App\Models\Customer;
use App\Models\Interaction;
use Tests\TestCase;

it('ログインユーザーは自分が担当する顧客に紐づく対応履歴を削除できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // 対応履歴削除処理にアクセス
    $response = $this->delete(route('interactions.destroy', $interaction));

    // 削除後、対応履歴一覧画面にリダイレクトされることを確認
    $response->assertRedirect(route('interactions.index'));

    // DB から対応履歴が論理削除されていることを確認
    $this->assertSoftDeleted($interaction);
});
