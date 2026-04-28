<?php

use App\Models\Customer;
use Tests\TestCase;

it('Customer は User に belongsTo する', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->create(['assigned_user_id' => $user->id]);

    // 担当者リレーションが正しく紐づくことを確認
    expect($customer->assignedUser->id)->toBe($user->id);
});
