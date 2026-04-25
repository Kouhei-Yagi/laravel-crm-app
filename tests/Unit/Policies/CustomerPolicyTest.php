<?php

use App\Models\User;
use App\Policies\CustomerPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class, TestCase::class);

it('一覧画面はログインユーザーなら見れる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // Policy の viewAny() を呼び出す
    $result = (new CustomerPolicy())->viewAny($user);

    // 許可されているか確認
    expect($result)->toBeTrue();
});
