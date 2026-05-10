<?php

use App\Models\Customer;
use App\Models\Interaction;
use Tests\TestCase;

it('ログインユーザーは content_keyword で部分一致検索ができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 検索にヒットする対応履歴とヒットしない対応履歴を作成
    Interaction::factory()->create([
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
        'content' => 'ヒットする対応履歴',
        'customer_id' => $customer->id,
    ]);
    Interaction::factory()->create([
        'interacted_at' => '2026-01-01T12:00',
        'type' => 'phone',
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
