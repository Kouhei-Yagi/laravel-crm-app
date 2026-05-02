<?php

use App\Models\Customer;
use App\Models\Project;
use Tests\TestCase;

it('ログインユーザーは自分が担当している顧客に紐づく案件を削除できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 顧客に紐づく案件を作成
    $project = Project::factory()->create(['customer_id' => $customer->id]);

    // 案件削除処理にアクセス
    $response = $this->delete("/projects/{$project->id}");

    // 削除後、案件一覧画面にリダイレクトされることを確認
    $response->assertRedirect('/projects');

    // DB から案件が論理削除されていることを確認
    $this->assertSoftDeleted('projects', ['id' => $project->id]);
});
