<?php

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Project;
use PhpParser\Node\Expr\FuncCall;
use Tests\TestCase;

it('Customer は User に belongsTo する', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 顧客に紐づく担当者のIDが、実際に紐づけたユーザーのIDと一致することを確認
    expect($customer->assignedUser->id)->toBe($user->id);
});

it('Customer は Project を hasMany する', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく案件を2件作成
    Project::factory()->count(2)->create(['customer_id' => $customer->id]);

    // 顧客に紐づく案件が2件取得できることを確認
    expect($customer->projects->count())->toBe(2);
});

it('Customer は Interaction を hasMany する', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく対応履歴を2件作成
    Interaction::factory()->count(2)->create(['customer_id' => $customer->id]);

    // 顧客に紐づく対応履歴が2件取得できることを確認
    expect($customer->interactions->count())->toBe(2);
});
