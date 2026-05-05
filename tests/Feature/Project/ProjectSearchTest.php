<?php

use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

it('ログインユーザーは案件の title で部分一致検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 検索にヒットする案件とヒットしない案件を作成
    Project::factory()->create([
        'customer_id' => $customer->id,
        'title' => 'ホームページ制作',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'title' => 'アプリ開発',
    ]);

    // 検索処理にアクセス
    $response = $this->get(route('projects.index', ['keyword' => 'ホームページ']));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 検索にヒットした案件名が表示されることを確認
    $response->assertSee('ホームページ制作');

    // 検索にヒットしない案件名は表示されないことを確認
    $response->assertDontSee('アプリ開発');
});

it('ログインユーザーは案件の customer_id で絞り込み検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customerA = Customer::factory()->create();
    $customerB = Customer::factory()->create();

    // 検索にヒットする案件とヒットしない案件を作成
    Project::factory()->create([
        'customer_id' => $customerA->id,
        'title' => 'A社の案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customerB->id,
        'title' => 'B社の案件',
    ]);

    // 検索処理にアクセス
    $response = $this->get(route('projects.index', ['customer_id' => $customerA->id]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 検索にヒットした案件が表示されることを確認
    $response->assertSee('A社の案件');

    // 検索にヒットしない案件は表示されないことを確認
    $response->assertDontSee('B社の案件');
});

it('ログインユーザーは案件の status で絞り込み検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 検索にヒットする案件とヒットしない案件を作成
    Project::factory()->create([
        'customer_id' => $customer->id,
        'status' => 'estimating',
        'title' => 'ヒットする案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'status' => 'proposing',
        'title' => 'ヒットしない案件',
    ]);

    // 検索処理にアクセス
    $response = $this->get(route('projects.index', ['status' => 'estimating']));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 検索にヒットした案件が表示されることを確認
    $response->assertSee('ヒットする案件');

    // 検索にヒットしない案件は表示されないことを確認
    $response->assertDontSee('ヒットしない案件');
});

it('ログインユーザーは assigned_user_id で絞り込み検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // 他ユーザーを作成
    $otherUser = User::factory()->create();

    // 任意の顧客を作成
    $customerA = Customer::factory()->create(['assigned_user_id' => $user->id]);
    $customerB = Customer::factory()->create(['assigned_user_id' => $otherUser->id]);

    // 検索でヒットする案件とヒットしない案件を作成
    Project::factory()->create([
        'customer_id' => $customerA->id,
        'assigned_user_id' => $user->id,
        'title' => 'ヒットする案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customerB->id,
        'assigned_user_id' => $otherUser->id,
        'title' => 'ヒットしない案件',
    ]);

    // 検索処理にアクセス
    $response = $this->get(route('projects.index', ['assigned_user_id' => $user->id]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 検索でヒットする案件は表示されることを確認
    $response->assertSee('ヒットする案件');

    // 検索でヒットしない案件は表示されないことを確認
    $response->assertDontSee('ヒットしない案件');
});
