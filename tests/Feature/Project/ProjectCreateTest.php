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

    // 送信するデータ（案件作成フォームに入力したデータ）
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
