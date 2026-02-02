# 開発メモ（dev_notes.md）

## 概要

このファイルは、開発過程での実装内容・実装手順・確認内容・気づき・課題を記録するためのメモです。
CRM アプリを構築する際に「どのように開発を進めたか」を示す補足資料として利用します。

---

## 機能名：設計フェーズ（要件整理・ER 図・テーブル定義・設計資料作成）

### 目的

- CRM アプリ開発の前段階として、必要な要件・データ構造・設計意図を明確にする
- 実装フェーズに入る前に、迷いを減らし、再現性の高い設計資料を整備する
- README を整え、プロジェクトの全体像を外部に示せる状態にする

### ブランチ名：**docs/initial-design**

### 実装日：2026-01-14 〜 2026-01-15

### 作成・変更ファイル

- docs/requirements.md（新規）
- docs/er-diagram.mmd（新規）
- docs/table_definitions.ods（新規）
- docs/master_values.md（新規）
- docs/design_notes.md（新規）
- docs/dev_notes.md（新規）
- README.md（更新）

### 実装内容

- 要件整理ドキュメント（requirements.md）の作成
- Mermaid を用いた ER 図（er-diagram.mmd）の作成
- テーブル定義書（table_definitions.ods）の作成
- マスタ値一覧（master_values.md）の作成
- 設計メモ（design_notes.md）の作成
- 開発メモ（dev_notes.md）の作成
- README の全面整理（目的・技術構成・セットアップ・ER 図セクションなど）

### 実装手順

1. **要件整理（requirements.md）**
    - CRM の目的・対象ユーザー・必要機能を文章化
    - 顧客 → 案件 → 対応履歴の階層構造を定義
    - 実務で必要な機能を洗い出し、優先度を整理

2. **ER 図の作成（er-diagram.mmd）**
    - Mermaid の記法を調査
    - VSCode に Mermaid 関連拡張機能を導入
    - customers / projects / interactions / users の関係を定義

3. **テーブル定義書の作成（table_definitions.ods）**
    - 各テーブルのカラム・型・制約を整理
    - 実務で使われる CRM の構造を参考に調整

4. **マスタ値の整理（master_values.md）**
    - 顧客ステータス・ランク・案件ステータス・対応種別を定義

5. **設計メモの作成（design_notes.md）**
    - 設計中に検討した内容・判断理由・迷った点を記録

6. **README の改善**
    - ディレクトリ構成に追記
    - ER 図セクションを追加
    - 今後の開発フローを整理

7. **開発メモ（dev_notes.md）の導入**
    - ブランチ単位で作業内容を記録する方針に決定
    - 再現性を高めるため、目的・手順・気づきを残す形式を採用

### 確認内容

- docs フォルダの構成が整理され、設計資料が一元管理できたこと
- Mermaid の ER 図が VSCode で正しく表示されること
- README がプロジェクトの入口として十分な情報を提供していること
- 設計フェーズの内容が dev_notes.md によって再現可能な形で記録されていること

### 気づき・課題

- Mermaid は draw.io より修正が圧倒的に楽で、Git 管理と相性が良い
- 設計資料を docs に分離することで README が読みやすくなった
- 設計メモ（design_notes.md）と開発メモ（dev_notes.md）は役割が異なるため両方必要
- 設計フェーズを丁寧に進めたことで、実装フェーズの迷いが大幅に減る見込み
- 今後は機能単位で dev_notes.md を継続的に更新していく運用が必要

---

## 機能名：Breeze 導入

### 目的

- 認証機能（ログイン・登録・パスワードリセットなど）を最小構成で素早く導入するため
- Laravel 標準の認証フローをベースに、業務システムとして必要な「ユーザー管理の土台」を整えるため
- Blade + Tailwind の構成を採用し、後続の CRUD 画面開発をスムーズに進めるため
- 認証まわりの実装コストを削減し、顧客・案件・対応履歴などの本質的な機能開発に集中するため
- Breeze のディレクトリ構成・ルーティング・UI を参考に、プロジェクト全体のコード規約を揃えるため

### ブランチ名：**feature/setup-breeze**

### 実装日：2026-01-16

### 導入により生成された主なファイル

- 認証関連のルート・ビュー・コントローラ
- Tailwind 設定ファイル
- ダッシュボード画面

    ※ すべて Breeze により自動生成されたもの

### 実装内容

- Breeze（Blade 版）を導入し、認証機能一式と Tailwind CSS のセットアップを追加
- ダークモード対応を有効化
- 認証後のダッシュボード画面が利用可能に

### 実装手順

1.  **Breeze のインストール**

    ```sh
    composer require laravel/breeze --dev
    php artisan breeze:install blade
    npm install
    npm run build
    ```

### 確認内容

- 認証ルート・ビュー・コントローラが生成されていること
- Register / Login / Logout が正常に動作すること
- /dashboard が認証保護されていること（未ログイン時は /login にリダイレクト）
- /register が認証後にアクセス不可であること（/dashboard にリダイレクト）
- パスワードリセット画面が表示されること
- 認証後のダッシュボードが表示されること
- UI が Tailwind ベースで構築されていること

    ※ パスワードリセットメール送信の実確認は今回はスキップ。

### 気づき・課題

- Breeze の導入により認証基盤が短時間で整い、実装フェーズにスムーズに移行できる
- パスワードリセットメールの送信確認は Mailpit などを導入すれば可能だが、現時点では優先度が低いため後回し
- ダークモード対応は自動で付与されるため、UI 調整時に活用できる

---

## 機能名：日本語化

### 目的

- アプリ全体の表示言語を日本語に統一し、業務システムとして自然な UI を提供するため
- バリデーションメッセージや認証画面を日本語化し、ユーザーにとって分かりやすい操作性を実現するため
- Faker のロケールを日本語化し、Factory や Seeder で生成されるダミーデータを日本語仕様にするため
- タイムゾーンを JST（Asia/Tokyo）に設定し、業務システムとして正しい日時管理を行うため
- Breeze の UI を日本語化し、後続の CRUD 開発をスムーズに進めるため

### ブランチ名：**feature/Lang-jp**

### 実装日：2026-01-16

### 作成・変更・自動生成されたファイル

- .env（更新）
- config/app.php（更新）
- lang/ja/\*（新規）
- resources/views/auth/\*（新規）
- resources/views/layouts/\*（新規）

### 実装内容

- Laravel のロケールを日本語（ja）に設定
- Faker のロケールを日本語（ja_JP）に設定
- SQLite の DB 設定を .env に明示
- タイムゾーンを Asia/Tokyo に変更
- Laravel Breeze の UI を日本語化（BreezeJP を使用）
- バリデーションメッセージを日本語化（lang:publish）

### 実装手順

1.  **.env の日本語化・SQLite 設定**

    ```コード
    APP_NAME="Customer Manager"
    APP_URL=http://customer-manager.test
    APP_LOCALE=ja
    APP_FAKER_LOCALE=ja_JP
    DB_CONNECTION=sqlite
    DB_DATABASE=./database/database.sqlite
    ```

2.  **タイムゾーン設定（`config/app.php`）**

    ```コード
    'timezone' => 'Asia/Tokyo',
    ```

3.  **Laravel の言語ファイルを公開**

    ```sh
    php artisan lang:publish
    ```

4.  **BreezeJP のインストールと適用**

    ```sh
    composer require askdkc/breezejp --dev
    php artisan breezejp
    ```

### 確認内容

- ログイン画面・登録画面が日本語化されていること
- バリデーションエラーメッセージが日本語で表示されること
- lang/ja ディレクトリが生成されていること
- Breeze の UI（auth, layouts）が日本語化されていること
- テストユーザーを登録し、created_at / updated_at が JST（日本時間）で保存されていること

### 気づき・課題

- BreezeJP により認証画面が一括で日本語化され、作業コストが大幅に削減できた
- Faker の日本語化は Factory / Seeder 作成時に改めて確認が必要
- .env の設定は日本語化フェーズでまとめて行うことで履歴が整理され、管理しやすくなった

---

## 機能名：マイグレーションファイル作成

### 目的

- 顧客・案件・対応履歴を管理するための基盤となるデータベース構造を定義するため
- 実務的な CRM を再現するため、外部キー・ENUM・nullable の扱いを適切に設計するため
- 今後の CRUD 実装をスムーズに進めるための正確で再現性の高いスキーマを整えるため

### ブランチ名：**feature/create-migrations**

### 実装日：2026-01-17 〜 2026-01-18

### 作成・変更・自動生成されたファイル

- database/migrations/create_customers_table.php（新規）
- database/migrations/create_projects_table.php（新規）
- database/migrations/create_interactions_table.php（新規）
- table_definitions.ods（更新）
- docs/er-diagram.mmd（更新）
- dev_notes.md（更新）
- README.md（更新）

### 実装内容

- customers / projects / interactions の 3 テーブルを作成
- ER 図を最新のテーブル構造に合わせて更新

### 実装手順

1. **customers テーブル作成**

    ```sh
    php artisan make:migration create_customers_table
    ```

2. **projects テーブル作成**

    ```sh
    php artisan make:migration create_projects_table
    ```

3. **interactions テーブル作成**

    ```sh
    php artisan make:migration create_interactions_table
    ```

4. **ER 図の更新**

- docs/er-diagram.mmd を最新のテーブル構造に合わせて修正
- nullable の表現を Mermaid の仕様に合わせて調整

5. **migrate 実行**

    ```sh
    php artisan migrate
    ```

### 確認内容

- customers / projects / interactions の 3 テーブルが作成されていること
- 外部キー制約が正しく設定されていること
- nullable の設定が意図通りになっていること
- ER 図がマイグレーション内容と完全に一致していること

### 気づき・課題

- マイグレーションは「1テーブル＝1ファイル」が最も履歴が明確で扱いやすい
- Mermaid の ER 図は nullable の正式な記法がないため、文字列として表現する必要がある（例："A / B / C - nullable"）
- 案件に紐づかない対応（project_id nullable）は CRM では必須の概念
- ENUM は簡単だが、将来的には master テーブル化も検討できる

---

## 機能名：顧客一覧表示

### 目的

- 顧客情報を一覧形式で表示し、顧客情報を素早く確認できるようにするため
- 今後の詳細画面・検索機能・CRUD 機能の基盤となる一覧画面を構築するため

### ブランチ名：**feature/customer-index**

### 実装日：2026-01-19 〜 2026-01-20

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/CustomerController.php`（新規）
- `app/Models/Customer.php`（新規）
- `routes/web.php`（更新）
- `resources/views/customers/index.blade.php`（新規）
- `database/factories/CustomerFactory.php`（新規）

### 実装内容

- 顧客一覧の表示（テーブル形式）
- 顧客と担当者（User）のリレーション表示
- ページネーションの導入
- Factory を用いたダミーデータ生成
- Tailwind CSS を用いた最低限の UI 改善

### 実装手順

#### 1. 一覧表示機能

1. リソースコントローラー（`CustomerController`）と `Customer` モデルを作成

    ```sh
    php artisan make:controller CustomerController --resource --model='Customer'
    ```

2. ルーティングの追加
    - `routes/web.php` にリソースルートを追加

3. `CustomerController@index` を実装
    - 顧客一覧を取得してビューに渡す

4. `Customer` モデルと `User` モデルにリレーションを設定

5. ビュー（顧客一覧ページ）の作成
    - テーブル形式で顧客一覧を表示

6. `Customer` モデルに `$fillable` を設定

7. ダミーデータを 1 件作成して動作確認

    ```sh
    php artisan tinker
    ```

#### 2. ページネーションを追加

1. `CustomerController@index` を修正
    - `all()` → `paginate(20)` に変更

2. ビューにページネーションリンクを追加
    - `{{ $customers->links() }}` を追記

3. ダミーデータ 30 件を作成
    1. Factory を作成

        ```sh
        php artisan make:factory CustomerFactory
        ```

    2. Factory にダミーデータを記述
        - `fake()->name()` / `fake()->kanaName()` / `fake()->company()` など
    3. `Customer` モデルに `use HasFactory;` を追加
    4. ダミーデータ作成を実行

        ```sh
        php artisan tinker
        App\Models\Customer::factory()->count(30)->create();
        ```

#### 3. 最低限の UI の改善

- テーブルが画面幅を超える場合に備えて `overflow-x-auto` を追加
- テーブルの規律性を整えるために border を追加
- 住所欄を `whitespace-normal break-words` に設定して折り返し表示
- 行の背景色を odd/even で切り替え、視認性を向上

### 確認内容

- ダミーデータが生成されていること
- 顧客一覧が正しく表示されること
- 担当者名（`User` モデルの `name`）が表示されること
- 一覧画面の UI が最低限の規律性と視認性を保っていること
- テーブルが横に切れず、スクロール可能になっていること
- ページネーションが正常に動作すること

### 気づき・課題

- Tailwind CSS のクラス構成は慣れが必要
- Factory により、実務に近いデータで UI を確認できるようになった
- 一覧画面は情報量が多いため、今後「表示項目の整理」や「検索・フィルタ機能」が必要になりそう
- 顧客名を詳細画面へのリンクにすることで UX が向上する見込み
- ステータスやランクをバッジ化すると、視認性がさらに向上しそう

---

## 機能名：顧客詳細表示

### 目的

- 顧客情報を 1 件ずつ確認できる詳細ページを提供するため
- 一覧ページから詳細ページへスムーズに遷移できる導線を整えるため
- 今後の編集（edit）・削除（delete）機能の基盤を作るため

### ブランチ名：**feature/customers-show**

### 実装日：2026-01-21

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/CustomerController.php`（更新）
- `resources/views/customers/show.blade.php`（新規）
- `resources/views/customers/index.blade.php`（更新）

### 実装内容

- 顧客詳細ページの新規作成
- `CustomerController@show` の実装（Route Model Binding を利用）
- 顧客一覧ページの表示項目を整理
- 顧客名リンクの追加
- UI をTailwind CSS を用いて一覧ページと同じ温度感に調整

### 実装手順

#### 1. 詳細表示機能

1. ルーティング（resource）で `show` が有効であることを確認
2. `CustomerController@show` を実装
3. `customers/show.blade.php` を作成

#### 2. 一覧表示内容の修正

1. 不要な表示項目削除し、一覧の情報量を適正化
2. 顧客名リンクの追加

#### 3. 詳細表示ページの最低限の UI 改善

1. Tailwind によるテーブルの整形（border / odd-even / 余白）
2. 住所の折り返し対応
3. 一覧ページと UI の統一感を確保
4. 一覧に戻るリンクを追加

### 確認内容

- 顧客一覧ページから詳細ページへ遷移できること
- 顧客情報が正しく表示されていること
- odd/even の背景色が適用されていること
- 住所が長い場合でもレイアウトが崩れないこと
- dark mode でも表示が崩れないこと
- 一覧ページと詳細ページの UI に統一感があること

### 気づき・課題

- Faker の `ja_JP` ロケールでも住所が数字から始まる場合がある
    - Faker の仕様で複数フォーマットが混在しているため
- ステータスやランクは後でバッジ化すると視認性が向上する
- 詳細ページは将来的に 2 カラムレイアウトにするとより実務的
- 一覧ページの検索・フィルタ機能は別ブランチで実装予定
- 編集（edit）・削除（delete）機能の導線は今後追加する必要あり

---

## 機能名：顧客新規登録

### 目的

- 顧客情報を新規登録できるようにするため
- CRM の基盤となる顧客データを正しく保存するため
- UI／UX・バリデーション・データ整合性を確保したフォームを提供するため

### ブランチ名：feature/customers-create

### 実装日：2026-01-21 ~ 2026-01-24

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/CustomerController.php`（更新）
- `resources/views/customers/create.blade.php`（新規）
- `resources/views/customers/index.blade.php`（更新）

### 実装内容

- 顧客新規登録フォームの作成
- フラッシュメッセージの追加
- ステータス・ランク・担当者を `<select>` 化
- バリデーション機能の追加
- `old()` とエラーメッセージ表示の実装
- UI をTailwind CSS を用いて一覧・詳細ページと同じ温度感に調整

### 実装手順

#### 1. 顧客新規作成ページ作成

1. resource ルートで `create` が有効であることを確認
2. `CustomerController@create` を実装
3. `resources/views/customers/create.blade.php` を作成

#### 2. 新規登録処理

1. resource ルートで `store` が有効であることを確認
2. `Customer` モデルに `$fillable` を設定
3. `CustomerController@store` を実装

#### 3. フラッシュメッセージ追加

1. `CustomerController@store` に `->with('success', '登録しました。')` を追加
2. `resources/views/customers/index.blade.php` にメッセージ表示欄を追加

#### 4. 新規作成ページのステータス欄・ランク欄・担当者欄を `<select>` に変更

1. `customers/create.blade.php` の該当欄を `<select>` に変更
2. ステータス・ランクはコントローラー側で配列として定義
3. 担当者は `User::all()` を取得し、`name` を表示・`id` を `value` に設定

#### 5. バリデーション追加

1. `CustomerController@store` にバリデーションルールを追加
2. `customers/create.blade.php` に `old()` と `@selected` を使用してエラー時の再選択に対応および `@error` を追加し、フィールドごとにエラー表示

#### 6. 詳細表示ページの最低限の UI 改善

1. index ・ show と同じ Tailwind のトーンに合わせてテーブルを調整
2. 住所の折り返し対応
3. 一覧に戻るリンクを追加

### 確認内容

- 正常に DB に登録される
- フラッシュメッセージが表示される
- 全フィールドのバリデーションが正しく動作する
- `old()` が正しく反映される
- `<select>` の選択状態がエラー後も保持される
- ダークモードで入力文字が見える（`text-gray-900 dark:text-gray-100`）
- UI が index / show と統一されている

### 気づき・課題

- UI を日本語にすると、バックエンド（enum）との整合性が必要
    - `value` は英語、表示は日本語という実務的な構造を理解
- `<select>` は「空欄を選べない」ため、`required` のテストは工夫が必要
- Tailwind のダークモードでは input の文字色が白になるため、`text-gray-900 dark:text-gray-100` を指定しないと文字が見えない

---

## 機能名：顧客編集

### 目的

- 既存の顧客情報を編集・更新できるようにするため
- CRM の基盤となる顧客データを正しく更新するため
- UI／UX・バリデーション・データ整合性を確保したフォームを提供するため

### ブランチ名：feature/customers-edit

### 実装日：2026-01-25

### 作成・変更・自動生成されたファイル

- `resources/views/customers/show.blade.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）
- `resources/views/customers/edit.blade.php`（新規）

### 実装内容

- 顧客詳細ページ（show）の変更
- 顧客編集ページ（edit）の作成
- 更新処理
- 更新後に顧客詳細ページへリダイレクト
- フラッシュメッセージの追加
- バリデーション機能の追加
- UI をTailwind CSS を用いて一覧・詳細・新規作成ページと同じ温度感に調整

### 実装手順

#### 1. 顧客編集ページ作成

1. `resources/views/customers/show.blade.php` を修正
    - 編集ボタンを追加
2. resource ルートで `edit` が有効であることを確認
3. `CustomerController@edit` を実装
    - ステータス・ランク・担当者一覧を取得してビューへ渡す
4. `resources/views/customers/edit.blade.php` を作成
    - 一覧・詳細・新規作成ページと同じ UI/UX を踏襲

#### 2. 顧客更新処理

1. resource ルートで `update` が有効であることを確認
2. `CustomerController@update` を実装
    - show ページへリダイレクト

#### 3. フラッシュメッセージ追加

1. `CustomerController@update` に`->with('success', '更新しました。')` を追加
2. `resources/views/customers/show.blade.php` にメッセージ表示欄を追加
    - 成功メッセージを緑色で表示

#### 4. バリデーション追加

1. `CustomerController@update` に create と同等のバリデーションルールを追加
2. `customers/edit.blade.php` に以下を実装
    - `old()` による入力値保持
    - `@selected` による `<select>` の選択状態保持
    - `@error` によるフィールドごとのエラー表示

### 確認内容

- 既存データがフォームに正しく初期表示されること
- ダークモードでも UI が崩れないこと
- 更新後に show ページへ遷移すること
- DB のデータが正しく更新されること
- フラッシュメッセージが表示されること
- バリデーションが正しく動作すること
- エラー時に old() が反映されること

### 気づき・課題

- postal_code の max:7 は「ハイフンなし前提」なので、仕様を明確にする必要がある
- create と update のバリデーションが重複しているため、FormRequest による共通化を検討
- ステータス・ランクの選択肢はモデル側に定数としてまとめることを検討
- 編集ボタン・戻るボタンの UI をコンポーネント化を検討

---

## 機能名：顧客削除（SoftDelete）

### 目的

- 顧客データを物理削除せず、安全に「論理削除」できるようにするため
- 誤操作によるデータ消失を防ぎ、復元可能な状態を保つため
- CRM としてのデータ保全性を高めるため
- 削除操作に対してユーザーが安心して利用できる UI／UX を提供するため

### ブランチ名：feature/customers-destroy

### 実装日：2026-01-26

### 作成・変更・自動生成されたファイル

- `app/Models/Customer.php`（更新）
- `resources/views/customers/show.blade.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）

### 実装内容

- Customer モデルを SoftDelete 対応に変更
- 顧客詳細ページに削除ボタンを追加
- CustomerController に削除処理（ destroy ）を追加
- 削除後に一覧ページへリダイレクト
- 削除成功時のフラッシュメッセージを追加
- 削除前の確認ダイアログを追加
- UI を既存のビューと同じトーンに統一

### 実装手順

#### 1. 顧客削除処理（SoftDelete）

1. Customer モデルを修正
    - `use SoftDeletes;` を追加
2. resource ルートで `destroy` が有効であることを確認
3. `CustomerController@destroy` を実装
    - `$customer->delete()` を実行（SoftDelete が発動）
    - 削除後は一覧ページへリダイレクト

#### 2. フラッシュメッセージ追加

1. `CustomerController@destroy` に`->with('success', '削除しました。')` を追加
2. `resources/views/customers/index.blade.php` にメッセージ表示欄を追加
    - 成功メッセージを緑色で表示

#### 3. 確認ダイアログ追加

1. `resources/views/customers/show.blade.php` を修正
    - 削除ボタンに `onclick="return confirm('本当に削除しますか？')"` を追加

### 確認内容

- 削除後に一覧ページへ遷移すること
- 一覧ページから削除済みデータが消えていること（SoftDelete が機能）
- DB 上ではレコードが残り、`deleted_at` に日時が入っていること
- ダークモードでも削除ボタン・メッセージが視認しやすいこと
- フラッシュメッセージが正しく表示されること
- 削除ボタン押下時に確認ダイアログが表示されること

### 気づき・課題

- SoftDelete によりデータは残るため、将来的に「復元機能（restore）」を追加する余地がある
- 関連データ（商談・メモなど）が増えた場合、削除時の整合性をどう扱うか検討が必要
- 削除操作は危険性が高いため、今後は UI コンポーネント化して再利用性を高めることを検討

---

## 機能名：案件一覧表示

### 目的

- 案件情報を一覧形式で表示し、案件情報を素早く確認できるようにするため
- 今後の詳細画面・CRUD 機能・検索機能の基盤となる一覧画面を構築するため

### ブランチ名：**feature/projects-index**

### 実装日：2026-01-26

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/ProjectController.php`（新規）
- `app/Models/Project.php`（新規）
- `routes/web.php`（更新）
- `resources/views/projects/index.blade.php`（新規）
- `database/migrations/2026_01_17_150058_create_projects_table.php`（更新）
- `app/Models/Customer.php`（更新）
- `app/Models/User.php`（更新）
- `database/factories/ProjectFactory.php`（新規）

### 実装内容

- `ProjectController@index` にて案件一覧を取得し、ビューへ渡す処理を実装
- `projects.index` ビューを作成し、案件一覧をテーブル形式で表示
- `Project`・`Customer`・`User` モデル間のリレーションを設定
- ページネーション（20件ごと）を追加
- `ProjectFactory` によるダミーデータ生成を実装（30件）
- 顧客一覧ページとレイアウト・テーブルデザインを統一

### 実装手順

#### 1. 一覧表示機能

1. リソースコントローラー（`ProjectController`）と `Project` モデルを作成

    ```sh
    php artisan make:controller ProjectController --resource --model='Project'
    ```

2. `routes/web.php` に projects のリソースルートを追加
3. `ProjectController@index` を実装し、案件一覧を取得してビューに渡す
4. `resources/views/projects/index.blade.php` を作成し、テーブル形式で案件一覧を表示

#### 2. 1件ダミーデータ作成

1. `Project` モデルに `$fillable` を設定
2. ダミーデータを 1 件作成して動作確認

    ```sh
    php artisan tinker
    ```

#### 3. リレーション設定

1. `Project`・`Customer`・`User` モデルにリレーションを設定
2. `resources/views/projects/index.blade.php`でリレーション経由の値を表示するよう修正

#### 4. ページネーションを追加

1. `ProjectController@index` を all() から paginate(20) に変更
2. ビューにページネーションリンク `{{ $projects->links() }}` を追加

#### 5. 30件ダミーデータ作成

1. `ProjectFactory` を作成

    ```sh
    php artisan make:factory ProjectFactory
    ```

2. `ProjectFactory` にダミーデータを記述
3. `Project` モデルに `use HasFactory;` を追加
4. ダミーデータ作成を実行

    ```sh
    php artisan tinker
    App\Models\Project::factory()->count(30)->create();
    ```

#### 6. 最低限の UI の改善

1. <x-app-layout> を使用し、顧客一覧ページと同じレイアウトに統一
2. Tailwind CSS を用いたテーブルデザインを適用
3. overflow-x-auto を追加し、横スクロールで表が切れないように調整
4. 行の偶数・奇数で背景色を変え、視認性を向上

### 確認内容

- 案件一覧が正しく表示されること
- 顧客名・担当者名がリレーション経由で取得できていること
- ダミーデータ 30 件が正しく生成・表示されていること
- ページネーションが正常に動作すること
- 顧客一覧ページと UI が概ね統一されていること
- テーブルが画面右で切れず、横スクロールで全列が確認できること

### 気づき・課題

- 案件内容（description）が長い場合、横スクロール量が増えるため、将来的にカラムの取捨選択や省略表示の検討余地あり
- ステータスをバッジ表示にすると視認性がさらに向上しそう
- 案件名・顧客名を詳細ページへのリンクにすることで、次の機能（詳細画面）への導線を作れる
- 検索・フィルタリング機能は今後の拡張ポイント
- 顧客一覧・案件一覧のテーブルをコンポーネント化すると保守性が高まりそう

---

## 機能名：案件詳細表示

### 目的

- 案件情報を 1 件ずつ確認できる詳細ページを提供するため
- 一覧ページから詳細ページへスムーズに遷移できる導線を整えるため
- 今後の編集（edit）・削除（delete）機能の基盤を作るため

### ブランチ名：**feature/projects-show**

### 実装日：2026-01-28 ~ 2026-01-29

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/ProjectController.php`（更新）
- `resources/views/projects/show.blade.php`（新規）
- `resources/views/projects/index.blade.php`（更新）
- `app/Models/Project.php`（更新）

### 実装内容

- 案件詳細ページの新規作成
    - 顧客名・担当者名の表示改善（ID → 名前）
    - 金額・日付のフォーマット統一
- `ProjectController@show` の実装（Route Model Binding を利用）
- 一覧ページの表示項目整理（情報量の適正化）
    - 案件名・顧客名のリンク追加
- 詳細ページの UI を顧客詳細ページと同じ温度感に調整

### 実装手順

#### 1. 詳細表示機能

1. ルーティング（resource）で `show` が有効であることを確認
    - `Route::resource('projects', ProjectController::class);` により自動的に `show` が利用可能
2. `ProjectController@show` を実装
    - 選択された案件データをビューへ渡す処理を追加
3. `projects/show.blade.php` を作成
    - 案件の基本情報をテーブル形式で表示する最低限の詳細ページを実装

#### 2. 詳細表示ページの表示改善

1. 顧客名・担当者の表示を ID → 名前に変更
    - リレーション（`customer` / `user`）を利用して名前を表示
    - `optional()` を使用して `null` 安全に対応
2. 税抜金額を区切り文字付きで表示
    - `number_format()` を使用して読みやすい金額表記に変更
3. 開始日・終了日を日付フォーマットで表示
    - `Project` モデルに `$casts` を追加
    - Blade 側で `format('Y-m-d')` を使用して統一した日付表示に変更

#### 3. 一覧表示ページの表示項目を修正

1. 不要な表示項目削除し、一覧の情報量を適正化
    - 案件内容・メモなど、一覧では不要な項目を削除
    - 開始日・終了日を「期間」列に統合
2. 案件名・顧客名に詳細ページへのリンクを追加
    - 案件名 → `projects.show`
    - 顧客名 → `customers.show`
    - リレーション（`$project->customer`）を利用し、`null` 安全にリンクを生成

#### 4. 詳細表示ページの最低限の UI 改善

- `<x-app-layout>` を使用し、顧客詳細ページと同じレイアウトに統一
- テーブルに交互色（odd/even）を適用し視認性を向上
- 「未設定」「（なし）」などの表記を統一
- 一覧に戻るボタンを追加し UX を改善

### 確認内容

- 詳細ページが正しく表示されること
- 金額・日付のフォーマットが統一されていること
- 一覧ページの表示項目が適正化されていること
- 顧客名リンク → 顧客詳細ページへ遷移すること
- 案件名リンク → 案件詳細ページへ遷移すること
- UI が顧客詳細ページと統一されていること

### 気づき・課題

- 視認性を向上させるため、案件ステータスをバッジ化することを検討
- 保守性を向上させるため、テーブルレイアウトをコンポーネント化することを検討

---

## 機能名：案件新規登録

### 目的

- 案件情報を新規登録できるようにするため

### ブランチ名：**feature/projects-create**

### 実装日：2026-01-29 ~ 2026-01-31

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/ProjectController.php`（更新）
- `resources/views/projects/create.blade.php`（新規）
- `app/Models/Project.php`（更新）
- `resources/views/projects/index.blade.php`（更新）
- `resources/views/projects/show.blade.php`（更新）

### 実装内容

- 案件新規作成ページの作成（`x-app-layout` を使用した UI 統一）
- フラッシュメッセージの追加（登録成功時）
- ステータスの日本語表示対応（`STATUSES` を利用）
- バリデーション機能の追加（`old()` による入力保持、`@error` によるエラー表示）

### 実装手順

#### 1. 案件新規作成ページの作成

1. ルーティング（resource）で `create` が有効であることを確認
    - `Route::resource('projects', ProjectController::class);` により自動的に `create` が利用可能
2. `ProjectController@create` を実装
    - 顧客一覧・ユーザー一覧・ステータス一覧を取得してビューへ渡す
3. `projects/create.blade.php` を作成

#### 2. 案件新規登録処理の実装

1. ルーティング（resource）で `store` が有効であることを確認
    - `Route::resource('projects', ProjectController::class);` により自動的に `store` が利用可能
2. `Project` モデルに `$fillable` を設定（すでに設定済）
3. `ProjectController@store` を実装
    - `Project::create()` による登録処理

#### 3. フラッシュメッセージの追加

1. `ProjectController@store` に `->with('success', '登録しました。')` を追加
2. `projects/index.blade.php` にフラッシュメッセージ表示を追加

#### 4. 案件新規作成ページの表示改善

1. `Project` モデルにステータス定数（`STATUSES`）を追加
    - 英語コード → 日本語ラベルの連想配列
2. `ProjectController@create` を変更
    - 顧客名・ステータス・担当者の選択肢を渡す
3. `projects/create.blade.php` を変更
    - 顧客名・ステータス・担当者のselect化

#### 5. バリデーション機能の追加

1. `ProjectController@store` にバリデーションルールを追加
2. `projects/create.blade.php` に old() と @error を追加

#### 6. 案件新規作成ページの最低限の UI 改善

- 顧客新規作成ページと同じ UI トーンに統一
- セクション見出し（基本情報・ステータス・期間など）を追加
- Tailwind のフォームスタイルを適用
- dark mode 対応
- 戻るボタンのデザイン統一

### 確認内容

- 正常に案件が登録されること
- フラッシュメッセージが一覧ページで表示されること
- select の選択状態が正しく復元されること
- バリデーションエラー時に old() が正しく保持されること
- ステータスが日本語で表示されること（一覧・詳細）
- UI が顧客新規作成ページと統一されていること
- dark mode でも崩れないこと

### 気づき・課題

- ステータスは英語コードを DB に保存し、日本語表示は定数で管理する方式が扱いやすい
- 金額入力は将来的にカンマ区切り UI を導入することを検討
- 一覧の視認性が向上させるため、ステータスを色付きバッジにすることを検討

---

## 機能名：案件編集

### 目的

- 登録されている案件情報を編集・更新できるようにするため
- 案件詳細ページから編集ページへ遷移できる導線を整備するため

### ブランチ名：**feature/projects-edit**

### 実装日：2026-02-01

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/ProjectController.php`（更新）
- `resources/views/projects/edit.blade.php`（新規）
- `resources/views/projects/show.blade.php`（更新）

### 実装内容

- 案件編集ページの作成（フォーム、`old()` 対応、エラー表示）
- 案件更新処理の実装（バリデーション、`update`、フラッシュメッセージ ）
- 案件詳細ページに編集ボタンを追加

### 実装手順

#### 1. 案件編集ページの作成

1. ルーティング（resource）で `edit` が有効であることを確認
    - `Route::resource('projects', ProjectController::class);` により自動的に `edit` が利用可能
2. `ProjectController@edit` を実装
    - 選択された案件データをビューへ渡す処理を追加
    - `Project` モデルにステータス定数（`STATUSES`、英語コード → 日本語ラベルの連想配列）を追加（すでに設定済）
    - 顧客名・ステータス・担当者の選択肢を渡す処理を追加
3. `projects/edit.blade.php` を作成
    - 開始日・終了日のフーマット化
    - 顧客名・ステータス・担当者のselect化

#### 2. 案件更新処理の実装

1. ルーティング（resource）で `update` が有効であることを確認
    - `Route::resource('projects', ProjectController::class);` により自動的に `update` が利用可能
2. `Project` モデルに `$fillable` を設定（すでに設定済）
3. `ProjectController@update` を実装
    - `Project::update()` による更新処理

#### 3. フラッシュメッセージの追加

1. `ProjectController@update` に `->with('success', '更新しました。')` を追加
2. `projects/show.blade.php` にフラッシュメッセージ表示を追加

#### 4. 案件詳細ページの表示改善

1. `projects/show.blade.php` に編集ボタンを追加

#### 5. バリデーション機能の追加

1. `ProjectController@update` にバリデーションルールを追加
2. `projects/edit.blade.php` に old() と @error を追加

#### 6. 案件新規作成ページの最低限の UI 改善

- 顧客編集ページと同じ UI トーンに統一
- セクション見出し（基本情報・ステータス・期間など）を追加
- Tailwind のフォームスタイルを適用
- dark mode 対応
- 戻るボタンのデザイン統一

### 確認内容

- 編集ページが正しく表示されること
- `old()` が正しく反映される（バリデーションエラー時に入力値が保持される）
- バリデーションエラーが正しく表示される
- フラッシュメッセージが詳細ページに表示されること
- 更新処理が正しく DB に反映されること
- 詳細ページから編集ページへ遷移できること
- UI が最低限整っていること

### 気づき・課題

- 顧客編集ページ・顧客新規作成ページ・案件新規作成ページの戻るボタンのUI を改善する必要あり
- 金額入力は将来的にカンマ区切り UI を導入することを検討

---

## 機能名：戻るボタンのデザイン統一

### 目的

- 顧客・案件の各ページで使用している「戻るボタン」のデザインと文言を統一し、UI の一貫性を高めるため
- 戻るボタンの遷移先を適切なページ（一覧 or 詳細）に揃え、ユーザーが迷わない導線を整備するため

### ブランチ名：**feature/ui-back-button-improve**

### 実装日：2026-02-02

### 作成・変更・自動生成されたファイル

- `resources/views/customers/edit.blade.php`（更新）
- `resources/views/customers/create.blade.php`（更新）
- `resources/views/projects/create.blade.php`（更新）

### 実装内容

- 顧客編集ページの戻るボタンを「一覧 → 詳細ページ」に変更
- 顧客新規作成ページの戻るボタンをリンクからボタン風 UI に変更
- 案件新規作成ページの戻るボタンをボタン風 UI に統一

### 実装手順

#### 1. 顧客編集ページ

- `resources/views/customers/edit.blade.php`の戻るボタンの遷移先を` customers.index`から` customers.show`に変更

#### 2. 顧客新規作成ページ

- `resources/views/customers/create.blade.php`の戻るリンクをボタン風 UI に変更

#### 3. 案件新規作成ページ

- `resources/views/projects/create.blade.php`の戻るリンクをボタン風 UI に変更

### 確認内容

- 各ページの戻るボタンが統一されたデザインで表示されること
- 顧客編集ページの戻るボタンが正しく「詳細ページ」に遷移すること
- 顧客新規作成・案件新規作成ページの戻るボタンが正しく「一覧」に遷移すること

### 気づき・課題

- 戻るボタンのコンポーネント化を検討すると、今後の UI 統一がさらに楽になる
- 顧客ページのステータス・ランクが英語表記のままなので、案件ページと同様に日本語化が必要（別ブランチで対応予定）

---
