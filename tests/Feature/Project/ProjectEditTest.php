<?php

use App\Models\Customer;
use App\Models\Project;
use tests\TestCase;

it('ログインユーザーは自分が担当している顧客に紐づく案件の編集画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 顧客に紐づいた案件を作成
    $project = Project::factory()->create(['customer_id' => $customer->id]);

    // 案件編集画面にアクセス
    $response = $this->get("/projects/{$project->id}/edit");

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 案件名が表示されることを確認
    $response->assertSee($project->title);
});

it('ログインユーザーは自分が担当する顧客に紐づく案件の更新処理ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 顧客に紐づく案件を作成
    $project = Project::factory()->create(['customer_id' => $customer->id]);

    // 送信するデータ（案件編集フォームに入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'customer_id' => $customer->id,
        'status' => 'estimating',
    ];

    // 案件更新処理にアクセス
    $response = $this->patch("/projects/{$project->id}", $data);

    // 更新後、案件詳細画面にリダイレクトされることを確認
    $response->assertRedirect("/projects/{$project->id}");

    // DB に案件の更新内容が保存されていることを確認
    $this->assertDatabaseHas('projects', [
        'title' => 'ホームページ制作',
        'customer_id' => $customer->id,
        'status' => 'estimating',
        'assigned_user_id' => $user->id,
    ]);
});
