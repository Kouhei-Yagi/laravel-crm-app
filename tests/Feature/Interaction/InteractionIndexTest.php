<?php

use App\Models\Interaction;
use Tests\TestCase;

it('ログインユーザーは対応履歴一覧を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 対応履歴を3件作成
    $interactions = Interaction::factory()->count(3)->create();

    // 対応履歴一覧画面にアクセス
    $response = $this->get(route('interactions.index'));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 対応履歴の必須項目が表示されることを確認
    foreach ($interactions as $interaction) {
        $response->assertSeeText($interaction->interacted_at->format('Y-m-d H:i'));
        $response->assertSeeText($interaction->customer->name);
        $response->assertSeeText($interaction->assignedUser->name);
        $response->assertSeeText(Interaction::TYPE[$interaction->type]);
    }
});
