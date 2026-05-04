<?php

use App\Models\User;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('案件一覧画面はログインユーザーなら誰でも見れる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // Policy の ViewAny を呼び出す
    $result = (new ProjectPolicy())->viewAny($user);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});
