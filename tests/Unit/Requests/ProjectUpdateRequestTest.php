<?php

use App\Http\Requests\ProjectUpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('title がない場合はバリデーションエラーになる', function () {
    // 送信するデータ（案件編集フォームに入力されたデータ）を作成
    $data = [
        'title' => '',
        'status' => 'estimating',
    ];

    // バリデーションルールを取得
    $rules = (new ProjectUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});

it('status がない場合はバリデーションエラーになる', function () {
    // 送信するデータ（案件編集フォームに入力されたデータ）を作成
    $data = [
        'title' => 'ホームページ制作',
        'status' => '',
    ];

    // バリデーションルールを取得
    $rules = (new ProjectUpdateRequest())->rules();

    // バリデーション実行
    $validator = Validator::make($data, $rules);

    // バリデーションエラーになることを確認
    expect($validator->fails())->toBeTrue();
});
