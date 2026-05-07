<?php

use App\Models\Interaction;
use Tests\TestCase;

it('ログインユーザーは対応履歴作成画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 対応履歴作成画面にアクセス
    $response = $this->get(route('interactions.create'));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 対応種別が表示されることを確認
    $response->assertSeeText('電話');
});
