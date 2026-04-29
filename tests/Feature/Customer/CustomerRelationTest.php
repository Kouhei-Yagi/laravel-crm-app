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

    // 顧客に紐づく担当者IDが、実際に紐づけたユーザーIDと一致することを確認
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

it('Project は Customer に belongsTo する', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく案件を作成
    $project = Project::factory()->create(['customer_id' => $customer->id]);

    // 案件に紐づく顧客IDが、実際に紐づけた顧客IDと一致することを確認
    expect($project->customer->id)->toBe($customer->id);
});

it('Interaction は Customer に belongsTo する', function () {
    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()->create(['customer_id' => $customer->id]);

    // 対応履歴に紐づく顧客IDが、実際に紐づけた顧客IDを一致していることを確認
    expect($interaction->customer->id)->toBe($customer->id);
});

it('User は Customers を hasMany する', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を2件作成
    Customer::factory()->count(2)->create(['assigned_user_id' => $user->id]);

    // ログインユーザーに紐づく顧客が2件取得できることを確認
    expect($user->customers->count())->toBe(2);
});
