<?php

use App\Models\Customer;
use App\Models\Project;
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
