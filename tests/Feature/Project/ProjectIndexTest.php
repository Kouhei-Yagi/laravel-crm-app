<?php

use App\Models\Project;
use Tests\TestCase;

it('ログインユーザーは案件一覧を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の案件を3件作成
    $projects = Project::factory()->count(3)->create();

    // 案件一覧画面にアクセス
    $response = $this->get('/projects');

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 各案件の案件名が表示されることを確認
    foreach ($projects as $project) {
        $response->assertSee($project->title);
    }
});
