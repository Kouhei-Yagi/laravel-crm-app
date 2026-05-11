<?php

use App\Models\Customer;
use App\Models\Interaction;
use Tests\TestCases;

it('ログインユーザーは interacted_at で昇順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく並び順がバラバラの対応履歴を3件作成
    Interaction::factory()
        ->for($customer, 'customer')
        ->create([
            'interacted_at' => '2026-03-01T12:00',
            'content' => 'テストC',
        ]);
    Interaction::factory()
        ->for($customer, 'customer')
        ->create([
            'interacted_at' => '2026-01-01T12:00',
            'content' => 'テストA',
        ]);
    Interaction::factory()
        ->for($customer, 'customer')
        ->create([
            'interacted_at' => '2026-02-01T12:00',
            'content' => 'テストB',
        ]);

    // ソート処理にアクセス
    $request = $this->get(route('interactions.index', [
        'sort' => 'interacted_at',
        'direction' => 'asc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $request->assertOk();

    // 昇順ソートで表示されることを確認
    $request->assertSeeInOrder(['テストA', 'テストB', 'テストC']);
});

it('ログインユーザーは interacted_at で降順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく並び順がバラバラの対応履歴を3件作成
    Interaction::factory()
        ->for($customer, 'customer')
        ->create([
            'interacted_at' => '2026-01-01T12:00',
            'content' => 'テストA',
        ]);
    Interaction::factory()
        ->for($customer, 'customer')
        ->create([
            'interacted_at' => '2026-03-01T12:00',
            'content' => 'テストC',
        ]);
    Interaction::factory()
        ->for($customer, 'customer')
        ->create([
            'interacted_at' => '2026-02-01T12:00',
            'content' => 'テストB',
        ]);

    // ソート処理にアクセス
    $request = $this->get(route('interactions.index', [
        'sort' => 'interacted_at',
        'direction' => 'desc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $request->assertOk();

    // 降順ソートで表示されることを確認
    $request->assertSeeInOrder(['テストC', 'テストB', 'テストA']);
});
