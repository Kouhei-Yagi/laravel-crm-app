<?php

use Tests\TestCase;

it('allows authenticated users to view the customer index page', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // /customers にアクセス
    $response = $this->get('/customers');

    // ステータスコード 200 を確認
    $response->assertOk();
});
