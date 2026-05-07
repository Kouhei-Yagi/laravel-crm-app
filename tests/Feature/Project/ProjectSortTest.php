<?php

use App\Models\Customer;
use App\Models\Project;
use Tests\TestCase;

it('ログインユーザーは title で昇順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく並び順がバラバラの案件を3件作成
    Project::factory()->create([
        'customer_id' => $customer->id,
        'title' => 'C案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'title' => 'A案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'title' => 'B案件',
    ]);

    // ソート処理にアクセス
    $response = $this->get(route('projects.index', [
        'sort' => 'title',
        'direction' => 'asc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 案件名が昇順にソートされて表示されることを確認
    $response->assertSeeInOrder(['A案件', 'B案件', 'C案件']);
});

it('ログインユーザーは title で降順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく並び順がバラバラの案件を3件作成
    Project::factory()->create([
        'customer_id' => $customer->id,
        'title' => 'A案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'title' => 'C案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'title' => 'B案件',
    ]);

    // ソート処理にアクセス
    $response = $this->get(route('projects.index', [
        'sort' => 'title',
        'direction' => 'desc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 案件名が降順にソートされて表示されることを確認
    $response->assertSeeInOrder(['C案件', 'B案件', 'A案件']);
});

it('ログインユーザーは customer_kana で昇順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を3件作成
    $customerA = Customer::factory()->create(['kana' => 'Aさん']);
    $customerB = Customer::factory()->create(['kana' => 'Bさん']);
    $customerC = Customer::factory()->create(['kana' => 'Cさん']);

    // 顧客に紐づく並び順がバラバラの案件を3件作成
    Project::factory()->create([
        'customer_id' => $customerC->id,
        'title' => 'C案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customerA->id,
        'title' => 'A案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customerB->id,
        'title' => 'B案件',
    ]);

    // ソート処理にアクセス
    $response = $this->get(route('projects.index', [
        'sort' => 'customer_kana',
        'direction' => 'asc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 案件名が昇順にソートされて表示されることを確認
    $response->assertSeeInOrder(['A案件', 'B案件', 'C案件']);
});

it('ログインユーザーは customer_kana で降順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を3件作成
    $customerA = Customer::factory()->create(['kana' => 'Aさん']);
    $customerB = Customer::factory()->create(['kana' => 'Bさん']);
    $customerC = Customer::factory()->create(['kana' => 'Cさん']);

    // 顧客に紐づく並び順がバラバラの案件を3件作成
    Project::factory()->create([
        'customer_id' => $customerA->id,
        'title' => 'A案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customerC->id,
        'title' => 'C案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customerB->id,
        'title' => 'B案件',
    ]);

    // ソート処理にアクセス
    $response = $this->get(route('projects.index', [
        'sort' => 'customer_kana',
        'direction' => 'desc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 案件名が降順にソートされて表示されることを確認
    $response->assertSeeInOrder(['C案件', 'B案件', 'A案件']);
});

it('ログインユーザーは amount で昇順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく並び順がバラバラの案件を3件作成
    Project::factory()->create([
        'customer_id' => $customer->id,
        'amount' => 300,
        'title' => 'C案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'amount' => 100,
        'title' => 'A案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'amount' => 200,
        'title' => 'B案件',
    ]);

    // ソート処理にアクセス
    $response = $this->get(route('projects.index', [
        'sort' => 'amount',
        'direction' => 'asc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 案件名が昇順にソートされて表示されることを確認
    $response->assertSeeInOrder(['A案件', 'B案件', 'C案件']);
});

it('ログインユーザーは amount で降順ソートができる', function () {
    // ログインユーザーを作成し、ログイン状態にする
    $this->loginUser();

    // 任意の顧客を作成
    $customer = Customer::factory()->create();

    // 顧客に紐づく並び順がバラバラの案件を3件作成
    Project::factory()->create([
        'customer_id' => $customer->id,
        'amount' => 100,
        'title' => 'A案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'amount' => 300,
        'title' => 'C案件',
    ]);
    Project::factory()->create([
        'customer_id' => $customer->id,
        'amount' => 200,
        'title' => 'B案件',
    ]);

    // ソート処理にアクセス
    $response = $this->get(route('projects.index', [
        'sort' => 'amount',
        'direction' => 'desc',
    ]));

    // アクセス成功（ステータスコード 200）を確認
    $response->assertOk();

    // 案件名が降順にソートされて表示されることを確認
    $response->assertSeeInOrder(['C案件', 'B案件', 'A案件']);
});
