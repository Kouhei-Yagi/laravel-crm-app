<?php

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\User;
use App\Policies\InteractionPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('対応履歴一覧画面はログインユーザーなら誰でも閲覧が許可されている', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // Policy の viewAny() を呼び出す
    $result = (new InteractionPolicy())->viewAny($user);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('対応履歴詳細画面はログインユーザーなら誰でも閲覧が許可されている', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()->create();

    // Policy の view() を呼び出す
    $result = (new InteractionPolicy())->view($user, $interaction);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});
