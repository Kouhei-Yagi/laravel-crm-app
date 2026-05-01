<?php

use App\Models\Customer;
use App\Models\Project;
use Tests\TestCase;

it('ログインユーザーは案件詳細画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 顧客に紐づく案件を作成
    $project = Project::factory()->create(['customer_id' => $customer->id]);

    // 案件詳細画面にアクセス
    $response = $this->get("/projects/{$project->id}");

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 案件名が表示されることを確認
    $response->assertSee($project->title);
});

it('未ログインユーザーは案件詳細画面にアクセスできない', function () {
    // 任意の案件を作成
    $project = Project::factory()->create();

    // 案件詳細画面にアクセス
    $response = $this->get("/projects/{$project->id}");

    // アクセス失敗（ステータスコード 302）を確認
    $response->assertStatus(302);

    // ログイン画面にリダイレクトされることを確認
    $response->assertRedirect('/login');
});
