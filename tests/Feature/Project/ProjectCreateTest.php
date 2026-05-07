<?php

use App\Models\Customer;
use App\Models\Project;
use Tests\TestCase;

it('ログインユーザーは案件作成画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 案件作成画面にアクセス
    $response = $this->get('/projects/create');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();
});

it('ログインユーザーは案件を登録できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 送信するデータ（案件作成フォームに入力したデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'customer_id' => $customer->id,
        'status' => 'estimating',
    ];

    // データを持って案件登録処理にアクセス
    $response = $this->post('/projects', $data);

    // 登録後、案件一覧画面にリダイレクトされることを確認
    $response->assertRedirect('/projects');

    // DB にデータが登録されていることを確認
    $this->assertDatabaseHas('projects', [
        'title' => 'ホームページ制作',
        'customer_id' => $customer->id,
        'status' => 'estimating',
        'assigned_user_id' => $user->id,
    ]);
});

it('title がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 送信するデータ（案件作成フォームに入力したデータ）を作成
    $data = [
        'title' => '',
        'customer_id' => $customer->id,
        'status' => 'estimating',
    ];

    // データを持って案件登録処理にアクセス
    $response = $this->post('/projects', $data);

    // バリデーションエラー（ステータスコード 302）を確認
    $response->assertStatus(302);

    // エラーメッセージがあることを確認
    $response->assertSessionHasErrors('title');
});

it('customer_id がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 送信するデータ（案件作成フォームに入力したデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'customer_id' => '',
        'status' => 'estimating',
    ];

    // データを持って案件登録処理にアクセス
    $response = $this->post('/projects', $data);

    // バリデーションエラー（ステータスコード 302）を確認
    $response->assertStatus(302);

    // エラーメッセージがあることを確認
    $response->assertSessionHasErrors('customer_id');
});

it('status がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 送信するデータ（案件作成フォームに入力したデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'customer_id' => $customer->id,
        'status' => '',
    ];

    // データを持って案件登録処理にアクセス
    $response = $this->post('/projects', $data);

    // バリデーションエラー（ステータスコード 302）を確認
    $response->assertStatus(302);

    // バリデーションエラーがあることを確認
    $response->assertSessionHasErrors('status');
});

it('未ログインユーザーは案件作成画面にアクセスできない', function () {
    // 案件作成画面にアクセス
    $response = $this->get('/projects/create');

    // アクセス失敗（ステータスコード 302）を確認
    $response->assertStatus(302);

    // ログイン画面にリダイレクトされることを確認
    $response->assertRedirect('/login');
});

it('未ログインユーザーは案件登録処理にアクセスできない', function () {
    // 案件登録処理にアクセス
    $response = $this->post('/projects');

    // アクセス失敗（ステータスコード 302）を確認
    $response->assertStatus(302);

    // ログイン画面にリダイレクトされることを確認
    $response->assertRedirect('/login');
});
