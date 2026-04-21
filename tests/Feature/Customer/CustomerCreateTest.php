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

it('customers テーブルへの新規登録テスト', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // 送信するデータ（Customer の入力フォーム）
    $date = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
    ];

    // POST /customers にデータを送信
    $response = $this->post('/customers', $date);

    // 正常にリダイレクトされることを確認
    $response->assertRedirect('/customers');

    // DB にデータが保存されていることを確認
    $this->assertDatabaseHas('customers', [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
    ]);
});
