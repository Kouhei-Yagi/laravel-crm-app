<?php

use Tests\TestCase;

it('ログインユーザーの顧客作成画面の表示テスト', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // /customers/create にログイン
    $response = $this->get('/customers/create');

    // 作成画面が正常に表示されることを確認
    $response->assertOk();
});

it('customers テーブルへの新規登録テスト', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // 送信するデータ（Customer の入力フォーム）
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
    ];

    // POST /customers にデータを送信
    $response = $this->post('/customers', $data);

    // 正常にリダイレクトされることを確認
    $response->assertRedirect('/customers');

    // DB にデータが保存されていることを確認
    $this->assertDatabaseHas('customers', [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => 'A',
    ]);
});

it('名前のバリデーションエラーのテスト', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // 送信するデータ（Customer の入力フォーム）
    $data = [
        'name' => '',
        'status' => 'prospect',
        'rank' => 'A',
    ];

    // POST /customers にデータを送信
    $response = $this->post('/customers', $data);

    // バリデーションエラー → 302 リダイレクトを確認
    $response->assertStatus(302);

    // name にエラーがあることを確認
    $response->assertSessionHasErrors(['name']);
});

it('ステータスのバリデーションエラーのテスト', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // 送信するデータ（Customer の入力フォーム）
    $data = [
        'name' => '山田 太郎',
        'status' => '',
        'rank' => 'A',
    ];

    // POST /customers にデータ送信
    $response = $this->post('/customers', $data);

    // バリデーションエラー → 302 リダイレクトを確認
    $response->assertStatus(302);

    // status にエラーがあることを確認
    $response->assertSessionHasErrors(['status']);
});

it('ランクのバリデーションエラーのテスト', function () {
    // ログインユーザーを作成してログイン
    $this->loginUser();

    // 送信するデータ（Customer の入力フォーム）
    $data = [
        'name' => '山田 太郎',
        'status' => 'prospect',
        'rank' => '',
    ];

    // POST /customers にデータ送信
    $response = $this->post('/customers', $data);

    // バリデーションエラー → 302 リダイレクを確認
    $response->assertStatus(302);

    // rank にエラーがあることを確認
    $response->assertSessionHasErrors(['rank']);
});

it('未ログインユーザーでの顧客新規登録画面アクセス制限（認可）テスト', function () {
    // ログインしないでアクセス
    $response = $this->get('/customers/create');

    // /login にリダイレクトされることを確認
    $response->assertRedirect('/login');
});

it('未ログインユーザーでの顧客新規登録処理アクセス制限（認可）テスト', function () {
    // ログインしないでアクセス
    $response = $this->post('/customers');

    // /login にリダイレクト
    $response->assertRedirect('/login');
});
