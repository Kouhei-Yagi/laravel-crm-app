<?php

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

it('ログインユーザーは content_keyword で部分一致検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 検索にヒットする対応履歴とヒットしない対応履歴を作成
    Interaction::factory()->create([
        'content' => 'ヒットする対応履歴',
        'customer_id' => $customer->id,
    ]);
    Interaction::factory()->create([
        'content' => 'ヒットしない対応履歴',
        'customer_id' => $customer->id,
    ]);

    // 検索処理にアクセス
    $response = $this->get(route('interactions.index', ['content_keyword' => 'ヒットする']));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 検索にヒットする対応履歴が表示されることを確認
    $response->assertSeeText('ヒットする対応履歴');

    // 検索にヒットしない対応履歴は表示されないことを確認
    $response->assertDontSeeText('ヒットしない対応履歴');
});

it('ログインユーザーは project_keyword で部分一致検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく案件を2件作成
    $projectA = Project::factory()->for($customer, 'customer')->create(['title' => '案件A']);
    $projectB = Project::factory()->for($customer, 'customer')->create(['title' => '案件B']);

    // 検索にヒットする対応履歴とヒットしない対応履歴を作成
    Interaction::factory()->create([
        'content' => 'ヒットする対応履歴',
        'customer_id' => $customer->id,
        'project_id' => $projectA->id,
    ]);
    Interaction::factory()->create([
        'content' => 'ヒットしない対応履歴',
        'customer_id' => $customer->id,
        'project_id' => $projectB->id,
    ]);

    // 検索処理にアクセス
    $response = $this->get(route('interactions.index', ['project_keyword' => '案件A']));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 検索にヒットする対応履歴が表示されることを確認
    $response->assertSeeText('ヒットする対応履歴');

    // 検索にヒットしない対応履歴は表示されないことを確認
    $response->assertDontSeeText('ヒットしない対応履歴');
});

it('ログインユーザーは type で絞り込み検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 検索にヒットする対応履歴をヒットしない対応履歴を作成
    Interaction::factory()->create([
        'type' => 'phone',
        'content' => 'ヒットする対応履歴',
        'customer_id' => $customer->id,
    ]);
    Interaction::factory()->create([
        'type' => 'email',
        'content' => 'ヒットしない対応履歴',
        'customer_id' => $customer->id,
    ]);

    // 検索処理にアクセス
    $response = $this->get(route('interactions.index', ['type' => 'phone']));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 検索にヒットする対応履歴が表示されることを確認
    $response->assertSeeText('ヒットする対応履歴');

    // 検索にヒットしない対応履歴は表示されないことを確認
    $response->assertDontSeeText('ヒットしない対応履歴');
});

it('ログインユーザーは customer_id で絞り込み検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を2件作成
    $customerA = Customer::factory()->create();
    $customerB = Customer::factory()->create();

    // 検索にヒットする対応履歴をヒットしない対応履歴を作成
    Interaction::factory()->create([
        'content' => 'ヒットする対応履歴',
        'customer_id' => $customerA->id,
    ]);
    Interaction::factory()->create([
        'content' => 'ヒットしない対応履歴',
        'customer_id' => $customerB->id,
    ]);

    // 検索処理にアクセス
    $response = $this->get(route('interactions.index', ['customer_id' => $customerA->id]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 検索にヒットする対応履歴が表示されることを確認
    $response->assertSeeText('ヒットする対応履歴');

    // 検索にヒットしない対応履歴は表示されないことを確認
    $response->assertDontSeeText('ヒットしない対応履歴');
});

it('ログインユーザーは assigned_user_id で絞り込み検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $user = $this->loginUser();

    // 他ユーザーを作成
    $otherUser = User::factory()->create();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 検索にヒットする対応履歴をヒットしない対応履歴を作成
    Interaction::factory()->create([
        'content' => 'ヒットする対応履歴',
        'customer_id' => $customer->id,
        'assigned_user_id' => $user->id,
    ]);
    Interaction::factory()->create([
        'content' => 'ヒットしない対応履歴',
        'customer_id' => $customer->id,
        'assigned_user_id' => $otherUser->id,
    ]);

    // 検索処理にアクセス
    $response = $this->get(route('interactions.index', ['assigned_user_id' => $user->id]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 検索にヒットする対応履歴が表示されることを確認
    $response->assertSeeText('ヒットする対応履歴');

    // 検索にヒットしない対応履歴は表示されないことを確認
    $response->assertDontSeeText('ヒットしない対応履歴');
});
