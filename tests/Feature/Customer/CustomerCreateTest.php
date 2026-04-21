<?php

use Test\Tests\TestCase;

it('ログインユーザーの顧客作成画面の表示テスト', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // /customers/create にログイン
    $response = $this->get('/customers/create');

    // ログイン成功（ステータスコード 200）を確認
    $response->assertOk('/customers/create');
});
