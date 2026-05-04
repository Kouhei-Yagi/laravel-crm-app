<?php

use App\Models\Project;
use App\Models\User;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('案件一覧画面はログインユーザーなら誰でも見れる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // Policy の viewAny() を呼び出す
    $result = (new ProjectPolicy())->viewAny($user);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('案件詳細画面はログインユーザーなら誰でも見れる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // 任意の案件を作成
    $project = Project::factory()->create();

    // Policy の view() を呼び出す
    $result = (new ProjectPolicy())->view($user, $project);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('案件作成画面はログインユーザーなら誰でも見れる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // Policy の create() を呼び出す
    $result = (new ProjectPolicy())->create($user);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});
