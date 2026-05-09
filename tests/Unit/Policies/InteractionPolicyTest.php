<?php

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\User;
use App\Policies\InteractionPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('ログインユーザーなら誰でも一覧の閲覧が許可されている', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // Policy の viewAny() を呼び出す
    $result = (new InteractionPolicy())->viewAny($user);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('ログインユーザーなら誰でも詳細の閲覧が許可されている', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()->create();

    // Policy の view() を呼び出す
    $result = (new InteractionPolicy())->view($user, $interaction);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('ログインユーザーなら誰でも新規作成が許可されている', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // Policy の create() を呼び出す
    $result = (new InteractionPolicy())->create($user);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('ログインユーザーは自分の担当する顧客に紐づく対応履歴なら更新が許可されている', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // Policy の update() を呼び出す
    $result = (new InteractionPolicy())->update($user, $interaction);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('ログインユーザーは他ユーザーが担当する顧客に紐づく対応履歴の更新が許可されていない', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // 他ユーザーを作成
    $otherUser = User::factory()->create();

    // 他ユーザーで顧客を作成
    $customer = Customer::factory()->for($otherUser, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($otherUser, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // ログインユーザーで Policy の update() を呼び出す
    $result = (new InteractionPolicy())->update($user, $interaction);

    // 許可されていないことを確認
    expect($result)->toBeFalse();
});

it('ログインユーザーは自分が担当する顧客の対応履歴の削除が許可されている', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // Policy の delete() を呼び出す
    $result = (new InteractionPolicy())->delete($user, $interaction);

    // 許可されていることを確認
    expect($result)->toBeTrue();
});

it('ログインユーザーは他ユーザーが担当する顧客に紐づく対応履歴の削除が許可されていない', function () {
    // ログインユーザーを作成
    $user = User::factory()->create();

    // 他ユーザーを作成
    $otherUser = User::factory()->create();

    // 他ユーザーで顧客を作成
    $customer = Customer::factory()->for($otherUser, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($otherUser, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // ログインユーザーで Policy の delete() を呼び出す
    $result = (new InteractionPolicy())->delete($user, $interaction);

    // 許可されていないことを確認
    expect($result)->toBeFalse();
});
