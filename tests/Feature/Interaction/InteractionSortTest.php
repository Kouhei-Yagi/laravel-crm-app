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

it('ログインユーザーは customer_kana で昇順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を3件作成
    $customerA = Customer::factory()->create(['kana' => 'あ']);
    $customerB = Customer::factory()->create(['kana' => 'か']);
    $customerC = Customer::factory()->create(['kana' => 'さ']);

    // 顧客に紐づく並び順がバラバラの対応履歴を3件作成
    Interaction::factory()->create([
        'customer_id' => $customerC->id,
        'content' => 'テストC',
    ]);
    Interaction::factory()->create([
        'customer_id' => $customerA->id,
        'content' => 'テストA',
    ]);
    Interaction::factory()->create([
        'customer_id' => $customerB->id,
        'content' => 'テストB',
    ]);

    // ソート処理にアクセス
    $request = $this->get(route('interactions.index', [
        'sort' => 'customer_kana',
        'direction' => 'asc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $request->assertOk();

    // 昇順ソートで表示されることを確認
    $request->assertSeeInOrder(['テストA', 'テストB', 'テストC']);
});

it('ログインユーザーは customer_kana で降順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を3件作成
    $customerA = Customer::factory()->create(['kana' => 'あ']);
    $customerB = Customer::factory()->create(['kana' => 'か']);
    $customerC = Customer::factory()->create(['kana' => 'さ']);

    // 顧客に紐づく並び順がバラバラの対応履歴を3件作成
    Interaction::factory()->create([
        'customer_id' => $customerA->id,
        'content' => 'テストA',
    ]);
    Interaction::factory()->create([
        'customer_id' => $customerC->id,
        'content' => 'テストC',
    ]);
    Interaction::factory()->create([
        'customer_id' => $customerB->id,
        'content' => 'テストB',
    ]);

    // ソート処理にアクセス
    $request = $this->get(route('interactions.index', [
        'sort' => 'customer_kana',
        'direction' => 'desc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $request->assertOk();

    // 降順ソートで表示されることを確認
    $request->assertSeeInOrder(['テストC', 'テストB', 'テストA']);
});

it('ログインユーザーは sort パラメータがない場合はデフォルトソートで表示される', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づいたバラバラの対応履歴を3件作成
    Interaction::factory()->create([
        'content' => 'テストC',
        'customer_id' => $customer->id,
        'interacted_at' => '2026-03-01T12:00',
    ]);
    Interaction::factory()->create([
        'content' => 'テストA',
        'customer_id' => $customer->id,
        'interacted_at' => '2026-01-01T12:00',
    ]);
    Interaction::factory()->create([
        'content' => 'テストB',
        'customer_id' => $customer->id,
        'interacted_at' => '2026-02-01T12:00',
    ]);

    // ソート処理にアクセス
    $request = $this->get(route('interactions.index'));

    // アクセス成功（ステータスコード 200）を確認
    $request->assertOk();

    // デフォルトソート（?sort=interacted_at&direction=desc）で表示されることを確認
    $request->assertSeeInOrder(['テストC', 'テストB', 'テストA']);
});
