<?php

use App\Models\Customer;
use App\Models\Project;
use PhpParser\Node\Expr\FuncCall;
use Tests\TestCase;

it('Customer は User に belongsTo する', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 担当者リレーションが正しく紐づくことを確認
    expect($customer->assignedUser->id)->toBe($user->id);
});

it('Customer は Project を hasMany する', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく案件を2件作成
    Project::factory()->count(2)->create(['customer_id' => $customer->id]);

    // 案件リレーションが正しく紐づくことを確認
    expect($customer->projects->count())->toBe(2);
});
