<?php

use App\Models\Customer;
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

it('案件更新処理は自分が担当する顧客に紐づく案件ならできる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 顧客に紐づく案件を作成
    $project = Project::factory()->create(['customer_id' => $customer->id]);

    // Policy の update() を呼び出す
    $result = (new ProjectPolicy())->update($user, $project);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('案件更新処理は自分が担当する顧客以外に紐づく案件ではできない', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = User::factory()->create();

    // 他ユーザーを作成
    $otherUser = User::factory()->create();

    // 他ユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $otherUser->id]);

    // 顧客に紐づく案件を作成
    $project = Project::factory()->create(['customer_id' => $customer->id]);

    // Policy の update() を呼び出す
    $result = (new ProjectPolicy())->update($user, $project);

    // 許可されていないことを確認
    expect($result)->toBeFalse();
});

it('案件削除処理は自分が担当する顧客に紐づく案件ならできる', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // 他ユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 顧客に紐づく案件を作成
    $project = Project::factory()->create(['customer_id' => $customer->id]);

    // Policy の delete() を呼び出す
    $result = (new ProjectPolicy())->delete($user, $project);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('案件削除処理は自分が担当する顧客以外に紐づく案件ではできない', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // 他ユーザーを作成
    $otherUser = User::factory()->create();

    // 他ユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $otherUser->id]);

    // 顧客に紐づく案件を作成
    $project = Project::factory()->create(['customer_id' => $customer->id]);

    // Policy の delete() を呼び出す
    $result = (new ProjectPolicy())->delete($user, $project);

    // 許可されていることを確認
    expect($result)->toBeFalse();
});
