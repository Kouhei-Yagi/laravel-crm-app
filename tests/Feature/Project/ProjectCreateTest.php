<?php

use Tests\TestCase;

it('ログインユーザーは案件作成画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 案件作成画面にアクセス
    $response = $this->get('/projects/create');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
});
