<?php

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Models\Interaction;
use App\Models\User;
use Tests\TestCase;

it('ログインユーザーは自分が担当する顧客に紐づく対応履歴の編集画面を表示できる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // 対応履歴編集画面にアクセス
    $response = $this->get(route('interactions.edit', $interaction));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 対応履歴が表示されることを確認
    $response->assertSee('value="' . $interaction->interacted_at->format('Y-m-d\TH:i') . '"', false);
    $response->assertSee('value="' . $interaction->customer->name . '"', false);
    $response->assertSeeText([
        Interaction::TYPES[$interaction->type],
        $interaction->content,
    ]);
});

it('ログインユーザーは自分が担当する顧客に紐づく対応履歴の更新処理ができる', function () {
    // ログインユーザーを作成し、ログイン状態ににする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // 送信するデータ（対応履歴編集フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => $customer->id,
    ];

    // 対応履歴更新処理にアクセス
    $response = $this->patch(route('interactions.update', $interaction), $data);

    // 更新後、対応履歴詳細画面にリダイレクトされることを確認
    $response->assertStatus(302);
    $response->assertRedirect(route('interactions.show', $interaction));

    // DB に更新内容が保存されていることを確認
    $this->assertDatabaseHas('interactions', [
        'interacted_at' => '2026-01-01 12:00:00',
        'type' => 'phone',
        'content' => 'テスト',
        'customer_id' => $customer->id,
        'assigned_user_id' => $user->id,
    ]);
});

it('対応履歴更新処理は interacted_at がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // 送信するデータ（対応履歴編集フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '',
        'type' => 'phone',
        'content' => 'テスト',
    ];

    // 対応履歴更新処理にアクセス
    $response = $this->patch(route('interactions.update', $interaction), $data);

    // バリデーションエラー（ステータスコード 302）になることを確認
    $response->assertStatus(302);

    // エラーメッセージがあることを確認
    $response->assertSessionHasErrors('interacted_at');
});

it('対応履歴更新処理は type がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // 送信するデータ（対応履歴編集フォームに入力されたデータ）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => '',
        'content' => 'テスト',
    ];

    // 対応履歴更新処理にアクセス
    $response = $this->patch(route('interactions.update', $interaction), $data);

    // バリデーションエラー（ステータスコード 302）になることを確認
    $response->assertStatus(302);

    // エラーメッセージがあることを確認
    $response->assertSessionHasErrors('type');
});

it('対応履歴更新処理は content がない場合はバリデーションエラーになる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // ログインユーザーで顧客を作成
    $customer = Customer::factory()->for($user, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($user, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // 送信するデータ（対応履歴編集フォームに入力されたでーた）を作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => '',
    ];

    // 対応履歴更新処理にアクセス
    $response = $this->patch(route('interactions.update', $interaction), $data);

    // バリデーションエラー（ステータスコード 302）になることを確認
    $response->assertStatus(302);

    // エラーメッセージがあることを確認
    $response->assertSessionHasErrors('content');
});

it('未ログインユーザーは対応履歴編集画面にアクセスすると、ログイン画面にリダイレクトされる', function () {
    // 任意の対応履歴を作成
    $interaction = Interaction::factory()->create();

    // 対応履歴編集画面にアクセス
    $response = $this->get(route('interactions.edit', $interaction));

    // ログイン画面にリダイレクトされることを確認
    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
});

it('未ログインユーザーは対応履歴更新処理にアクセスすると、ログイン画面にリダイレクトされる', function () {
    // 任意の対応履歴を作成
    $interaction = Interaction::factory()->create();

    // 送信するデータを作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => 'テスト',
    ];

    // 対応履歴更新処理にアクセス
    $response = $this->patch(route('interactions.update', $interaction), $data);

    // ログイン画面にリダイレクトされる
    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
});

it('ログインユーザーは他ユーザーの顧客に紐づく対応履歴の編集画面にアクセスできない', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 他ユーザーを作成
    $otherUser = User::factory()->create();

    // 他ユーザーで顧客を作成
    $customer = Customer::factory()->for($otherUser, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($otherUser, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // ログインユーザーで他ユーザーの対応履歴編集画面にアクセス
    $response = $this->get(route('interactions.edit', $interaction));

    // アクセス失敗（ステータスコード 403）を確認
    $response->assertForbidden();
});

it('ログインユーザーは他ユーザーの顧客に紐づく対応履歴の更新処理にアクセスできない', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 他ユーザーを作成
    $otherUser = User::factory()->create();

    // 他ユーザーで顧客を作成
    $customer = Customer::factory()->for($otherUser, 'assignedUser')->create();

    // 顧客に紐づく対応履歴を作成
    $interaction = Interaction::factory()
        ->for($otherUser, 'assignedUser')
        ->for($customer, 'customer')
        ->create();

    // 送信するデータを作成
    $data = [
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => 'テスト',
    ];

    // ログインユーザーで他ユーザーの対応履歴更新処理にアクセス
    $response = $this->patch(route('interactions.update', $interaction), $data);

    // アクセス失敗（ステータスコード 403）を確認
    $response->assertForbidden();
});
