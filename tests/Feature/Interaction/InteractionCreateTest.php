<?php

use App\Models\Customer;
use App\Models\Interaction;
use Tests\TestCase;

it('ログインユーザーは対応履歴作成画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 対応履歴作成画面にアクセス
    $response = $this->get(route('interactions.create'));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 対応種別が表示されることを確認
    $response->assertSeeText('電話');
});

it('ログインユーザーは対応履歴を DB に登録できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 送信するデータ（対応履歴作成フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => $customer->id,
    ];

    // 対応履歴登録処理にアクセス
    $response = $this->post(route('interactions.store'), $data);

    // 登録後、対応履歴一覧にリダイレクトすることを確認
    $response->assertRedirect(route('interactions.index'));

    // DB に登録されていることを確認
    $this->assertDatabaseHas('interactions', [
        'interacted_at' => '2026-01-01 12:00:00',
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => $customer->id,
        'assigned_user_id' => $user->id,
    ]);
});

it('対応履歴登録処理で interacted_at がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 送信するデータ（対応履歴作成フォームから入力されたデータ）を作成
    $data = [
        'interacted_at' => '',
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => $customer->id,
    ];

    // 対応履歴登録処理にアクセス
    $response = $this->post(route('interactions.store'), $data);

    // バリデーションエラー（ステータスコード 302）を確認
    $response->assertStatus(302);

    // エラーメッセージが存在することを確認
    $response->assertSessionHasErrors('interacted_at');
});

it('対応履歴登録処理で type がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 送信するデータ（対応履歴作成フォームから入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => '',
        'content' => 'テスト',
        'customer_id' => $customer->id,
    ];

    // 対応履歴登録処理にアクセス
    $response = $this->post(route('interactions.store'), $data);

    // バリデーションエラー（ステータスコード 302）を確認
    $response->assertStatus(302);

    // エラーメッセージが存在することを確認
    $response->assertSessionHasErrors('type');
});

it('対応履歴登録処理で content がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 送信するデータ（対応履歴作成フォームから入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => '',
        'customer_id' => $customer->id,
    ];

    // 対応履歴登録処理にアクセス
    $response = $this->post(route('interactions.store'), $data);

    // バリデーションエラー（ステータスコード 302）を確認
    $response->assertStatus(302);

    // エラーメッセージが存在することを確認
    $response->assertSessionHasErrors('content');
});

it('対応履歴登録処理で customer_id がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 送信するデータ（対応履歴作成フォームから入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => '',
    ];

    // 対応履歴登録処理にアクセス
    $response = $this->post(route('interactions.store'), $data);

    // バリデーションエラー（ステータスコード 302）を確認
    $response->assertStatus(302);

    // エラーメッセージが存在することを確認
    $response->assertSessionHasErrors('customer_id');
});
