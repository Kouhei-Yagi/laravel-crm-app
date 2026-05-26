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

## 機能名：顧客ステータス・ランクの日本語化

### 目的

- 顧客管理画面におけるステータス・ランクの表示を日本語化し、ユーザーにとって分かりやすい UI に改善するため
- 内部値（英語コード）と表示値（日本語ラベル）を分離し、保守性を高めるため
- 顧客管理・案件管理の一覧・詳細・新規作成・編集の全ページで統一した表示を実現するため

### ブランチ名：**feature/customer-status-rank-japanese**

### 実装日：2026-02-03

### 作成・変更・自動生成されたファイル

- `app/Models/Customer.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）
- `resources/views/customers/index.blade.php`（更新）
- `resources/views/customers/show.blade.php`（更新）
- `resources/views/customers/create.blade.php`（更新）
- `resources/views/customers/edit.blade.php`（更新）

### 実装内容

- 顧客一覧ページでステータスを日本語表示に変更
- 顧客一覧ページの並び順を作成日降順に変更
- 顧客詳細・新規作成・編集ページでステータス・ランクを日本語表示に変更

### 実装手順

#### 1. 顧客一覧ページの日本語化

1. `Customer` モデルにステータス定数（`STATUSES`）を追加
    - 英語コード → 日本語ラベルの連想配列
2. `customers/index.blade.php` を変更
    - ステータスの日本語化

#### 2. 顧客一覧ページの表示順

1. `CustomerController@index` を変更
    - 作成日降順に変更

#### 3. 顧客詳細ページの日本語化

1. `Customer` モデルにランク定数（`RANKS`）を追加
    - 英語コード → 日本語ラベルの連想配列
2. `customers/show.blade.php` を変更
    - ステータス・ランクの日本語化

#### 4. 顧客新規作成ページの日本語化

1. `CustomerController@create` を変更
    - ステータス・ランクの選択肢を渡す
2. `customers/create.blade.php` を変更
    - `<select>` を `$key => $label` 形式に変更

#### 5. 顧客編集ページの日本語化

1. `CustomerController@edit` を変更
    - ステータス・ランクの選択肢を渡す
2. `customers/edit.blade.php` を変更
    - `<select>` を `$key => $label` 形式に変更

### 確認内容

- 一覧ページでステータスが日本語で表示されること
- 詳細ページでステータス・ランクが日本語で表示されること
- 新規作成・編集ページで日本語ラベルの選択肢が表示されること
- DB に保存される値は英語コード（内部値）のままであること
- 全ページで表示が統一されていること

### 気づき・課題

- ステータス・ランクの日本語化は定数で管理することで保守性が向上した
- アクセサ（getStatusLabelAttribute() など）の導入を検討
- 選択肢の管理が増える場合は FormRequest や Enum の導入も検討
- 今回の変更は UI 改善の一環として、一覧の並び順変更も同じブランチで実装した

---

## 機能名：案件削除（SoftDelete）

### 目的

- 登録されている案件情報を削除できるようにするため
- 案件データを物理削除せず、論理削除（SoftDelete） として扱うことで、誤削除によるデータ消去を防ぎ、復元や監査ログとしての利用を可能にするため

### ブランチ名：**feature/projects-destroy**

### 実装日：2026-02-04

### 作成・変更・自動生成されたファイル

- `app/Models/Project.php`（更新：`SoftDeletes` を追加）
- `app/Http/Controllers/ProjectController.php`（更新：`destroy` メソッドを実装）
- `resources/views/projects/show.blade.php`（更新：削除ボタン追加）

### 実装内容

- 論理削除処理（SoftDelete）を実装
- `projects/show.blade.php` に削除ボタンを追加
- 削除ボタンに確認ダイアログを追加
- `ProjectController@destroy` を実装
- フラッシュメッセージを追加

### 実装手順

#### 1. 案件削除処理（SoftDelete）

1. `projects/show.blade.php`に削除ボタンを追加
2. `Project` モデルに`use SoftDeletes;` を追加
3. `Route::resource('projects', ProjectController::class);` により `destroy` が利用可能であることを確認
4. `ProjectController@destroy` を実装
    - `$project->delete()` を実行（SoftDelete が発動）
    - 削除後は一覧ページへリダイレクト

#### 2. フラッシュメッセージ追加

1. `ProjectController@destroy` に`->with('success', '削除しました。')` を追加
2. `projects/index.blade.php` にメッセージ表示欄（成功メッセージを緑色で表示）を追加（すでに実装済）

#### 3. 確認ダイアログ追加

1. `projects/show.blade.php` の削除ボタンに `onclick="return confirm('本当に削除しますか？')"` を追加

### 確認内容

- 削除ボタンを押すと確認ダイアログが表示されること
- 「OK」を押すと SoftDelete が実行され、`deleted_at` に日時が入ること
- 削除後、一覧ページにリダイレクトされること
- 一覧ページにフラッシュメッセージが表示されること
- 削除済みデータが一覧に表示されないこと（SoftDelete の仕様通り）
- DB 上ではレコードが残っていること（物理削除されていない）

### 気づき・課題

- 今回は削除のみだが、将来的に「復元（restore）」や「完全削除（forceDelete）」の実装も検討
- 削除済みデータの一覧（ゴミ箱機能）の実装を検討
- 権限管理を導入を検討

---

## 機能名：案件履歴一覧表示

### 目的

- 案件に紐づく対応履歴（Interaction）を一覧で確認できるようにするため
- 案件・顧客・担当者とのリレーションを横断して情報を把握できるようにするため
- 管理者・担当者が過去の対応内容を素早く参照できるようにするため

### ブランチ名：**feature/interactions-index**

### 実装日：2026-02-04 ~ 2026-02-06

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/InteractionController.php`（新規）
- `app/Models/Interaction.php`（新規）
- `routes/web.php`（更新：ルート追加）
- `resources/views/interactions/index.blade.php`（新規）
- `database/factories/InteractionFactory.php`（新規）
- `app/Models/Customer.php`（更新：リレーション設定）
- `app/Models/Project.php`（更新：リレーション設定）
- `app/Models/User.php`（更新：リレーション設定）

### 実装内容

- 案件履歴の一覧表示機能を実装
    - `Project` / `Customer` / `User` とのリレーションを設定
    - 対応種別の日本語化（定数 TYPE）
    - 日付のフォーマット（対応日時・作成日・更新日）
    - ページネーションの追加
    - ダミーデータ（30件）を作成
    - UI を Laravel Breeze / Tailwind のトーンに合わせて調整
    - テーブルに横スクロール（overflow-x-auto）を追加

### 実装手順

#### 1. 一覧表示機能

1. リソースコントローラー（`InteractionController`）と `Interaction` モデルを作成

    ```sh
    php artisan make:controller InteractionController --resource --model='Interaction'
    ```

2. `routes/web.php` に `Interactions` のリソースルートを追加
3. `InteractionController@index` を実装し、`orderBy()` + `paginate()` で一覧取得
4. `resources/views/interactions/index.blade.php` を作成し、テーブル形式で表示

#### 2. 1件ダミーデータ作成

1. `Interaction` モデルに `$fillable` を設定
2. ダミーデータを 1 件作成して動作確認

    ```sh
    php artisan tinker
    ```

#### 3. リレーション設定

1. `Interaction` → `Project`・`Customer`・`User` モデルにリレーションを設定
2. `resources/views/interactions/index.blade.php`でリレーション経由の値を表示するよう修正

#### 4. 対応種別の日本語化、日付フォーマット化

1. `Interaction` モデルに定数 `TYPE` （英語コード → 日本語ラベルの連想配列）と `$casts` （`interacted_at' => 'datetime`）を追加
2. `interactions/index.blade.php` の変更
    - 対応種別欄に`App\Models\Interaction::TYPE[]`を追加
    - 対応日時に`format('Y-m-d H:i')`を追加
    - 作成日・更新日に`format('Y-m-d')`を追加

#### 5. デフォルト表示順の設定、ページネーションを追加

1. `InteractionController@index` を `all()` から `orderBY()->paginate()` に変更
2. ビューにページネーションリンク `{{ $interactions->links() }}` を追加

#### 6. 30件ダミーデータ作成

1. `InteractionFactory` を作成

    ```sh
    php artisan make:factory InteractionFactory
    ```

2. `InteractionFactory` にダミーデータを記述
3. `Interaction` モデルに `use HasFactory;` を追加
4. ダミーデータ作成を実行

    ```sh
    php artisan tinker
    App\Models\Interaction::factory()->count(30)->create();
    ```

#### 7. 最低限の UI の改善

- <x-app-layout> を使用し、既存ページと統一したレイアウトに変更
- Tailwind CSS によるテーブルデザインを適用
- `overflow-x-auto` を追加し、横スクロール対応
- 偶数・奇数行で背景色を変え視認性を向上

### 確認内容

- 一覧が正しく取得・表示されること
- リレーション先のデータが正しく表示されること
- 日付フォーマットが意図通り表示されていること
- ページネーションが正常に動作していること
- ダミーデータ 30 件で UI が崩れないこと
- 横スクロールが機能すること
- ダークモードでも視認性が保たれていること

### 気づき・課題

- 内容やメモが長い場合、横スクロール量が増えるため、将来的にカラムの取捨選択や省略表示を検討
- ステータスをバッジ表示にすると視認性がさらに向上しそう
- 案件名・顧客名・担当者を詳細ページへのリンクにすることで、次の機能（詳細画面）への導線を作れる
- 検索・フィルタリング機能は今後の拡張ポイント
- 顧客一覧・案件一覧・案件履歴一覧のテーブルをコンポーネント化すると保守性が高まりそう

---

## 機能名：案件履歴詳細表示

### 目的

- 案件履歴情報を 1 件ずつ確認できる詳細ページを提供するため
- 一覧ページから詳細ページへスムーズに遷移できる導線を整えるため
- 今後の編集（edit）・削除（delete）機能の基盤を作るため

### ブランチ名：**feature/interactions-show**

### 実装日：2026-02-06 ~ 2026-02-07

### 作成・変更・自動生成されたファイル

- `resources/views/interactions/show.blade.php`（新規）
- `app/Http/Controllers/InteractionController.php`（更新：show メソッド実装）
- `resources/views/Interactions/index.blade.php`（更新：リンク追加）

### 実装内容

- 案件履歴詳細ページの新規作成
    - 対応種別の日本語化
    - 日付のフォーマット統一
    - 顧客名・案件名・担当者の表示改善（ID → 名前）
- `InteractionController@show` の実装（Route Model Binding を利用）
- 一覧ページの表示項目整理（情報量の適正化）
    - 内容欄は抜粋して表示
    - 案件名・顧客名のリンク追加
- UI を顧客詳細・案件詳細ページと同じ温度感に調整

### 実装手順

#### 1. 詳細表示機能

1. ルーティング（resource）で `show` が有効であることを確認
    - `Route::resource('interactions', InteractionController::class);` により自動的に `show` が利用可能
2. `InteractionController@show` を実装
    - 選択された`Interaction`モデルをビューへ渡す処理を実装
3. `Interactions/show.blade.php` を作成
    - 案件履歴の基本情報をテーブル形式で表示

#### 2. 案件履歴詳細ページの表示改善

1. `Interaction` → `Project`・`Customer`・`User` モデルにリレーションを設定（すでに設定済）
2. `Interaction` モデルに定数 `TYPE` （英語コード → 日本語ラベルの連想配列）と `$casts` （`interacted_at' => 'datetime`）を追加（すでに設定済）
3. `interactions/show.blade.php` の変更
    - 対応種別欄に`App\Models\Interaction::TYPE[]`を追加
    - 対応日時に`format('Y-m-d H:i')`を追加
    - 作成日・更新日に`format('Y-m-d')`を追加
    - 顧客名・案件名・担当者にリレーション経由の値を表示するよう修正

#### 3. 案件履歴一覧ページの表示項目整理

1. 不要な表示項目（作成日・更新日・メモ）削除し、一覧の情報量を適正化
2. 内容に`Str::limit()`を追加し、本文を抜粋して表示
3. 案件名・顧客名に詳細ページへのリンクを追加

#### 4. 最低限の UI の改善

- <x-app-layout> を使用し、既存ページと統一したレイアウトに変更
- Tailwind CSS によるテーブルデザインを適用
- 偶数・奇数行で背景色を変え視認性を向上
- 「未設定」「（なし）」などの表記を統一
- 一覧に戻るボタンを追加し UX を改善

### 確認内容

- 一覧ページから詳細ページへ遷移できること
- 案件履歴情報が正しく表示されていること
- 偶数・奇数行で背景色が変わっていること
- dark mode でも表示が崩れないこと
- 一覧ページと詳細ページの UI に統一感があること
- 「案件名・顧客名」リンクと「一覧に戻る」ボタンが正しく遷移できること

### 気づき・課題

- 担当者（user）には詳細ページが存在しないため、リンクは未実装
- type_label アクセサを導入するとビューがさらに簡潔になる余地あり
- 編集・削除ボタンは別ブランチで追加予定
- 一覧ページの検索・フィルタ機能は今後の改善ポイント

---

## 機能名：案件履歴新規登録

### 目的

- 案件履歴情報を新規登録できるようにするため

### ブランチ名：**feature/interactions-create**

### 実装日：2026-02-10 ~ 2026-02-11

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/InteractionController.php`（更新：create/storeメソッド実装）
- `resources/views/interactions/create.blade.php`（新規）
- `resources/views/interactions/index.blade.php`（更新：フラッシュメッセージ表示、リンク生成エラー修正、新規作成ボタン追加）

### 実装内容

- 案件履歴新規作成ページの新規作成
    - 対応種別・顧客名・案件名・担当者を`<select>`化
    - UI を`<x-app-layout>`とTailwind CSS を用いて既存ページと統一
- 案件履歴登録処理
    - フラッシュメッセージの追加
    - バリデーション機能の追加
- 案件履歴一覧ページの改善
    - `project`が`null`の場合のリンク生成エラーを修正
    - 新規作成ボタンを追加

### 実装手順

#### 1. 新規作成ページの作成

1. ルーティング（resource）で `create` が有効であることを確認
2. `InteractionController@create` を実装
3. `interactions/create.blade.php` を作成

#### 2. 新規登録処理の実装

1. ルーティング（resource）で `store` が有効であることを確認
2. `Interaction` モデルに `$fillable` を設定（既存）
3. `InteractionController@store` を実装
    - `Interaction::create()` による登録処理

#### 3. フラッシュメッセージの追加

1. `InteractionController@store` に `->with('success', '登録しました。')` を追加
2. `interactions/index.blade.php` にフラッシュメッセージ表示を追加

#### 4. 新規作成ページの表示改善

1. `Interaction`モデルに定数`TYPE`を追加（既存）
2. `Interaction` → `Project`・`Customer`・`User` モデルにリレーションを設定（既存）
3. `InteractionController@create`で選択肢（対応種別・案件名・顧客名・担当者）を渡す
4. `interactions/create.blade.php` の変更
    - 対応種別・顧客名・案件名・担当者を`<select>`化
    - 対応種別は`TYPE`定数の値を表示するよう修正
    - 顧客名・案件名・担当者はリレーション経由の値を表示するよう修正

#### 5. バリデーション機能の追加

1. `InteractionController@store` にバリデーションルールを追加
2. `interactions/create.blade.php` に`@error`と`old()`を追加

#### 6. 最低限の UI 改善

1. `interactions/create.blade.php` を修正
    - <x-app-layout> を使用し、既存ページと統一したレイアウトに変更
    - Tailwind CSS によるフォームデザインを適用
    - セクション見出し（基本情報・関連情報）を追加
    - 「一覧に戻る」ボタンを追加
    - ダークモード対応
2. `interactions/index.blade.php` に「新規作成」ボタンを追加

### 確認内容

- 新規作成ページが表示されること
- 新規登録処理が行われ、DBに保存・一覧ページに表示されること
- 登録後にフラッシュメッセージが表示されること
- 新規作成ページの対応種別・顧客名・案件名・担当者の選択肢が正しく表示されること
- バリデーションエラーメッセージが正しく表示されること
- バリデーションエラー時に`old()`が正しく保持されること
- UI が既存ページと統一されていること
- ダークモードでも表示が崩れないこと
- 「一覧に戻る」「新規作成」ボタンが正しく遷移できること

### 気づき・課題

- `option`タグの`@selected`属性の使い方に慣れる必要がある
- `content`を`nullable`のままにするか`required`にするか要検討
- `Interaction`モデルの`user()`メソッドを`assignedUser()`に変更するか要検討（可読性向上のため）

---

## 機能名：案件履歴編集

### 目的

- 登録されている案件履歴情報を編集・更新できるようにするため

### ブランチ名：**feature/interactions-edit**

### 実装日：2026-02-12 ~ 2026-02-14

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/InteractionController.php`（更新：edit/updateメソッド実装）
- `resources/views/interactions/edit.blade.php`（新規）
- `resources/views/interactions/show.blade.php`（更新：編集ボタン追加）

### 実装内容

- 案件履歴編集ページの新規作成
    - 対応日時を`datetime-local`形式に整形
    - 対応種別・顧客名・案件名・担当者を`<select>`化
    - UI を`<x-app-layout>`とTailwind CSS を用いて既存ページと統一
- 案件履歴更新処理
    - フラッシュメッセージの追加
    - バリデーション機能の追加
- 案件履歴詳細ページの改善
    - 編集ボタンを追加

### 実装手順

#### 1. 編集ページ作成

1. `interactions/show.blade.php`に編集ボタンを追加
2. ルーティング（resource）で `edit`が有効であることを確認
3. `InteractionController@edit`を実装
4. `interactions/edit.blade.php`を作成

#### 2. 更新処理実装

1. ルーティング（resource）で `update` が有効であることを確認
2. `Interaction` モデルに `$fillable` を設定（既存）
3. `InteractionController@update` を実装
    - `Interaction::update()` による登録処理

#### 3. フラッシュメッセージ追加

1. `InteractionController@edit` に `->with('success', '更新しました。')` を追加
2. `interactions/show.blade.php` にフラッシュメッセージ表示を追加

#### 4. 編集ページの表示改善

1. `Interaction`モデルに定数`TYPE`を追加（既存）
2. `Interaction` → `Project`・`Customer`・`User` モデルにリレーションを設定（既存）
3. `InteractionController@edit`で選択肢（対応種別・案件名・顧客名・担当者）を渡す
4. `interactions/edit.blade.php` の変更
    - 対応日時のフーマット化
    - 対応種別・顧客名・案件名・担当者を`<select>`化・`@selected`で制御
    - 対応種別は`TYPE`定数の値を表示するよう修正
    - 顧客名・案件名・担当者はリレーション経由の値を表示するよう修正

#### 5. バリデーション機能追加

1. `InteractionController@update` にバリデーションルールを追加
2. `interactions/edit.blade.php` に`@error`と`old()`を追加

#### 6. 最低限のUI調整

1. `interactions/edit.blade.php` を修正
    - <x-app-layout> を使用し、既存ページと統一したレイアウトに変更
    - Tailwind CSS によるフォームデザインを適用
    - セクション見出し（基本情報・関連情報）を追加
    - 「詳細ページに戻る」ボタンを追加
    - ダークモード対応

### 確認内容

- 編集ページが表示されること
- 更新処理後、DBの更新、詳細・一覧ページに更新内容が表示されること
- 更新後にフラッシュメッセージが表示されること
- 編集ページの対応種別・顧客名・案件名・担当者の選択肢が正しく表示されること
- バリデーションエラーメッセージが正しく表示されること
- バリデーションエラー時に`old()`が正しく保持されること
- UI が既存ページと統一されていること
- ダークモードでも表示が崩れないこと
- 「編集」「詳細ページに戻る」ボタンが正しく遷移できること

### 気づき・課題

- `content`を`nullable`のままにするか`required`にするか要検討
- `Interaction`モデルの`user()`メソッドを`assignedUser()`に変更するか要検討（可読性向上のため）
- 一覧ページのテーブルの右端に「編集」「削除」などの操作ボタンを配置するか要検討

---

## 機能名：案件履歴削除（SoftDelete）

### 目的

- 登録されている案件履歴情報を削除（SoftDelete）できるようにするため
- 案件履歴データを物理削除せず、論理削除（SoftDelete） として扱うことで、誤削除によるデータ消去を防ぎ、復元や監査ログとしての利用を可能にするため

### ブランチ名：**feature/interactions-destroy**

### 実装日：2026-02-14

### 作成・変更・自動生成されたファイル

- `app/Models/Interaction.php`（更新：`SoftDeletes`を追加）
- `app/Http/Controllers/InteractionController.php`（更新：destroyメソッド実装）
- `resources/views/interactions/show.blade.php`（更新：削除ボタン・確認ダイアログ追加）

### 実装内容

- 案件履歴削除処理（SoftDelete）
    - フラッシュメッセージの追加
- 案件履歴詳細ページの改善
    - 削除ボタンを追加
    - 確認ダイアログの追加

### 実装手順

#### 1. 削除処理実装

1. `Interactions/show.blade.php`に削除ボタンを追加
2. `Interaction`モデルに`use SoftDeletes;`を追加
3. ルーティング（resource）で `destroy`が有効であることを確認
4. `InteractionController@destroy`を実装
    - `$interaction->delete()`を実装（SoftDelete が発動）
    - 削除後は一覧ページへリダイレクト

#### 2. フラッシュメッセージ追加

1. `InteractionController@destroy` に `->with('success', '削除しました。')` を追加
2. `interactions/index.blade.php` にフラッシュメッセージ表示を追加（既存）

#### 3. 確認ダイアログの追加

1. `interactions/show.blade.php` の削除ボタンに `onclick="return confirm('本当に削除しますか？')"` を追加

### 確認内容

- 削除処理後、一覧ページにリダイレクトされること
- 削除済みデータが一覧に表示されないこと（SoftDelete の仕様通り）
- DB 上では`deleted_at`に日時が入り、レコードが残っていること（物理削除されていない）
- 一覧ページにフラッシュメッセージが表示されること
- 削除ボタンを押すと確認ダイアログが表示され、「OK」を押すと削除処理が実行されること

### 気づき・課題

- 「復元（restore）」や「完全削除（forceDelete）」の実装も要検討
- 削除済みデータの一覧（ゴミ箱機能）の実装を要検討
- 権限管理の導入を要検討

---

## 機能名：命名統一修正

### 目的

- 命名揺れを解消して統一することで、コードの可読性・保守性を向上させるため

### ブランチ名：**refactor/naming**

### 実装日：2026-02-15

### 作成・変更・自動生成されたファイル

- モデル（リレーション名の統一）
    - `app/Models/customer.php`（更新：`user()` → `assignedUser()`）
    - `app/Models/project.php`（更新：`user()` → `assignedUser()`）
    - `app/Models/interaction.php`（更新：`user()` → `assignedUser()`）
- コントローラー（担当者選択肢の変数名統一）
    - `app/Http/Controllers/CustomerController.php`（更新：`$users` → `$assignedUsers`）
    - `app/Http/Controllers/ProjectController.php`（更新：`$users` → `$assignedUsers`）
    - `app/Http/Controllers/InteractionController.php`（更新：`$users` → `$assignedUsers`）
- ビュー（担当者表示・選択肢の統一）
    - `resources/views/Customers/index.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/Customers/show.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/Customers/create.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/Customers/edit.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/Projects/index.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/Projects/show.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/Projects/create.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/Projects/edit.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/interactions/index.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/interactions/show.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/interactions/create.blade.php`（更新：`users` → `assignedUsers`）
    - `resources/views/interactions/edit.blade.php`（更新：`users` → `assignedUsers`）

### 実装内容

- 担当者リレーションの命名統一
    - `user()` → `assignedUser()`に変更
    - 外部キー`assigned_user_id`と整合性を取る
- コントローラー内の変数名統一
    - `$users` → `$assignedUsers`
- ビュー内の呼び出し統一
    - `$model->user->name` → `$model->assignedUser->name`
    - 選択肢の変数名 `$users` → `$assignedUsers`

### 実装手順

#### 1. リレーション名の統一

1. `Customer`・`Project`・`Interaction`モデルの`user()`を`assignedUser()`に変更
2. `CustomerController`・`ProjectController`・`InteractionController`の`$users`を`assignedUsers`に変更
3. `index`・`show`ビューの`user()`を`assignedUser()`に変更
4. `create`・`edit`ビューの`$users`を`assignedUsers`に変更

### 確認内容

- 顧客・案件・案件履歴関連のすべてページ（`index`・`show`・`create`・`edit`）で担当者が正しく表示されること
- `assigned_user_id`が正しく保存・更新されること

### 気づき・課題

- 担当者表示の「未設定」表記が画面ごとに揺れているため、UI 統一ブランチでまとめて統一する必要がある
- 今回の命名統一により、後続の棚卸し（モデル整理・ルーティング整理）が進めやすくなった
- コントローラがシンプルで、リレーション呼び出しが Blade に集約されているため、命名統一の影響範囲が限定されていて修正が容易だった

---

## 機能名：UI 統一修正

### 目的

- 各ページのUI を統一することで、視認性・操作性・保守性を向上させるため

### ブランチ名：**refactor/ui-unify**

### 実装日：2026-02-16

### 作成・変更・自動生成されたファイル

- `resources/views/Customers/index.blade.php`（更新）
- `resources/views/Customers/show.blade.php`（更新）
- `resources/views/Customers/create.blade.php`（更新）
- `resources/views/Customers/edit.blade.php`（更新）
- `resources/views/Projects/index.blade.php`（更新）
- `resources/views/Projects/show.blade.php`（更新）
- `resources/views/Projects/create.blade.php`（更新）
- `resources/views/Projects/edit.blade.php`（更新）
- `resources/views/interactions/index.blade.php`（更新）
- `resources/views/interactions/show.blade.php`（更新）
- `resources/views/interactions/create.blade.php`（更新）
- `resources/views/interactions/edit.blade.php`（更新）

### 実装内容

- indexビュー
    - 担当者が空欄の場合は「未設定」表示に統一
    - リンクスタイルを統一
    - ページネーションの余白を統一
    - 新規作成ボタンを追加
- showビュー
    - 担当者が空欄の場合は「未設定」表示に統一
    - メモ・内容が空欄の場合は「（なし）」表示に統一
    - 作成日・更新日を追加
    - 必要箇所に改行反映を適用
- createビュー
    - `<textarea>`に`whitespace-pre-line`を追加
    - `placeholder`の追加
    - `<select>`の初期値に「選択してください」を追加
- editビュー
    - `<textarea>`に`whitespace-pre-line`を追加
    - `placeholder`の追加
    - `<select>`の初期値に「選択してください」を追加

### 実装手順

#### 1. index表示改善

- 「未設定」の表示を`<span class="text-gray-400">未設定</span>`に統一
- リンクスタイルを`text-blue-600 hover:underline`に統一
- ページネーションの余白を`<div class="mt-4">`に統一
- `customers`・`projects`にも新規作成ボタンを追加

#### 2. show表示改善

- 「未設定」の表示を`<span class="text-gray-400">未設定</span>`に統一
- 「（なし）」の表示を`<td class="px-3 py-2 border">{{ $models->memo ?: '（なし）' }}</td>`に統一
- `customers`・`projects`に作成日・更新日を追加

#### 3. create表示改善

- `<textarea>`に`whitespace-pre-line`を追加
- `placeholder`の追加
- `<select>`の初期値に「選択してください」を追加

#### 4. edit表示改善

- `<textarea>`に`whitespace-pre-line`を追加
- `placeholder`の追加
- `<select>`の初期値に「選択してください」を追加

### 確認内容

- 各ページのUI が統一されていること
- 全ページで「未設定」「（なし）」の表記揺れがないこと
- `placeholder` の文体が統一されていること
- `<textarea>`の改行が正しく反映されること
- `<select>`の初期値がすべて「選択してください」になっていること
- Tailwind クラスが統一されていること
- ページネーションの余白が統一されていること
- 新規作成ボタンの位置・スタイルが統一されていること

### 気づき・課題

- UI のBlade コンポーネント化を要検討
- UX 向上のため、入力補助（郵便番号→住所自動入力など）の追加を要検討
- バリデーションメッセージの統一（日本語化・文体統一）を要検討
- 保守性を向上させるため、Tailwind のフォームレイアウトの共通化を要検討

---

## 機能名：DB スキーマ修正（必須項目・外部キー制約の統一）

### 目的

- DB とアプリ層のデータの整合性を取るため
- テーブル定義書・ER 図・設計メモ・要件整理・README を最新仕様に同期させるため

### ブランチ名：**refactor/db-schema-consistency**

### 実装日：2026-02-17

### 作成・変更・自動生成されたファイル

- `docs/table_definitions.ods`（更新）
- `docs/er-diagram.mmd`（更新）
- `docs/design_notes.md`（更新）
- `docs/requirements.md`（更新）
- `README.md`（更新）
- `database/migrations/2026_01_17_145847_create_customers_table.php`（更新）
- `database/migrations/2026_01_17_150058_create_projects_table.php`（更新）
- `database/migrations/2026_01_17_150118_create_interactions_table.php`（更新）

### 実装内容

- 必須項目（NOT NULL）の統一
    - `customers`・`projects`テーブルの`assigned_user_id`を必須化
- 外部キー制約の統一
    - `customers`・`projects`・`interactions`テーブルの`assigned_user_id`カラムを`restrict`制約に変更
    - `projects`・`interactions`テーブルの`customer_id`カラムを`restrict`制約に変更
- テーブル定義書・ER 図の更新
    - `user_id` → `assigned_user_id` に統一
    - 必須項目の更新
    - 外部キー制約の方針を反映
- 設計ドキュメントの更新
    - 設計メモに「担当者必須化」「外部キー制約の方針」「postal_code の理由」を追記
    - 要件整理に「担当者必須」「担当者自動設定」「外部キー制約の業務ルール」を追記
    - README を最新仕様に合わせて全面更新

### 実装手順

#### 1. 初期マイグレーションファイルを修正

- NOT NULL / nullable の見直し
- 外部キー制約（restrict / nullOnDelete）の適用

#### 2. テーブル定義書・ER 図を修正

- カラム名・外部キー制約・必須項目を最新化

#### 3. 設計メモ・要件整理・README を更新

- DB 設計の変更点をすべて反映
- 外部キー制約の方針を明文化
- 担当者必須化の理由を追記

#### 4. migrate:fresh で DB を再構築

- ダミーデータのためデータ消失は問題なし
- スキーマの整合性を確認

### 確認内容

- マイグレーションが正常に実行されること
- 外部キー制約が期待通りに動作すること
    - 顧客削除 → 案件がある場合は削除不可
    - 案件削除 → 対応履歴は残り、project_id が NULL になる
    - 担当者削除 → 顧客・案件・履歴がある場合は削除不可
- テーブル定義書・ER 図と実際のテーブル構造が一致していること
- 設計メモ・要件整理・README の内容が最新仕様と矛盾しないこと

### 気づき・課題

- 担当者削除は`restrict`のため、今後「ユーザー無効化（`active`フラグ）」を要検討
- 案件の金額（見積金額・契約金額）をどこまで扱うかは要検討
- DB 設計が固まったことで、次のバリデーション統一ブランチの作業が明確になった

---

## 機能名：バリデーション統一修正

### 目的

- 顧客・案件・案件履歴のバリデーション仕様を統一し、入力ルールの不整合を解消するため
- UI 上の必須/任意の扱いを統一し、ユーザーが迷わない画面にするため
- コントローラー・ビュー・Factory のデータ整合性を改善するため

### ブランチ名：**refactor/validation-unify**

### 実装日：2026-02-19 ~ 2026-02-22

### 作成・変更・自動生成されたファイル

- コントローラー
    - `app/Http/Controllers/CustomerController.php`（更新）
    - `app/Http/Controllers/ProjectController.php`（更新）
    - `app/Http/ControllersInteractionController.php`（更新）
- ビュー
    - `resources/views/Customers/index.blade.php`（更新）
    - `resources/views/Customers/show.blade.php`（更新）
    - `resources/views/Customers/create.blade.php`（更新）
    - `resources/views/Customers/edit.blade.php`（更新）
    - `resources/views/Projects/index.blade.php`（更新）
    - `resources/views/Projects/show.blade.php`（更新）
    - `resources/views/Projects/create.blade.php`（更新）
    - `resources/views/Projects/edit.blade.php`（更新）
    - `resources/views/interactions/index.blade.php`（更新）
    - `resources/views/interactions/show.blade.php`（更新）
    - `resources/views/interactions/create.blade.php`（更新）
    - `resources/views/interactions/edit.blade.php`（更新）
- ファクトリー
    - `database/factories/CustomerFactory.php`（更新）
    - `database/factories/ProjectFactory.php`（更新）
    - `database/factories/InteractionFactory.php`（更新）
- シーダー
    - `DatabaseSeeder.php`（新規）

### 実装内容

- バリデーションの統一
    - 電話番号・郵便番号の厳正化
    - 担当者をログインユーザーで自動設定
    - ログインユーザーが担当する顧客・案件のみ選択可に変更
- UI 調整
    - 担当者欄を削除（自動設定のため）
    - 必須マーク、入力必須文言の追加
    - 不要なフォームの削除、表示のみに変更
    - 任意項目は未設定を表示できるように変更
    - 顧客名と案件名は編集不可（表示のみ）に変更
- Factory の修正
    - 日本語のダミーデータを生成するよう最適化
    - `ProjectFactory`：顧客の担当者と案件の担当者を一致させる
    - `InteractionFactory`：案件あり/なしをランダム生成（案件ありの場合は顧客との整合性を保証）、担当者は顧客の担当者に統一
- DatabaseSeeder を作成
    - 日本語データで顧客・案件・案件履歴を一括生成

### 実装手順

#### 1. バリデーションの統一

1. `CustomerController`を修正

- `phone`：`string` → `regex:/^[0-9\-]+$/`
- `postal_code`：`string|max:7` → `digits:7`
- `assigned_user_id`をログインユーザーで自動設定
- `create`/`edit`画面から`$assignedUsers = User::all();`を削除（UI から担当者選択を排除）

2. `ProjectController`を修正

- `assigned_user_id`をログインユーザーで自動設定
- `$customers = Customer::where('assigned_user_id', auth()->id())->get();`に変更
- `create`/`edit`画面から`$assignedUsers = User::all();`を削除（UI から担当者選択を排除）

3. `InteractionController`を修正

- `content`：`nullable` → `required`
- `assigned_user_id`をログインユーザーで自動設定
- `$customers = Customer::where('assigned_user_id', auth()->id())->get();`に変更
- `$projects = Project::where('assigned_user_id', auth()->id())->get();`に変更
- `create`/`edit`画面から`$assignedUsers = User::all();`を削除（UI から担当者選択を排除）

#### 2. UI 調整

1. `Customers/index・show・create・edit`を修正

- 任意項目は未設定を表示するよう統一
- `create`/`edit`画面から担当者欄を削除（自動設定のため）
- 必須項目に`*`を追加
- 「`*`は入力必須項目です。」を追加

2. `Projects/index・show・create・edit`を修正

- 任意項目は未設定を表示するよう統一
- `create`/`edit`画面から担当者欄を削除（自動設定のため）
- 必須項目に`*`を追加
- 「`*`は入力必須項目です。」を追加
- `edit`画面では`customer_name`を表示のみ（非編集）

3. `Interactions/index・show・create・edit`を修正

- 任意項目は未設定を表示するよう統一
- `create`/`edit`画面から担当者欄を削除（自動設定のため）
- 必須項目に`*`を追加
- 「`*`は入力必須項目です。」を追加
- `project_id`と`customer_id`は編集不可（表示のみ）

#### 3. Factory の修正

1. `CustomerFactory`を修正

- `department`・`position`・`status`・`rank`を`fake()->randomElement`に変更
- `address`を`fake()->prefecture() . fake()->city() . fake()->streetAddress()`に変更
- `assigned_user_id`を`User::factory()`に変更

2. `ProjectFactory`を修正

- `start_date`と`end_date`に`optional()`を追加
- `assigned_user_id`を顧客の担当者と同じになるように設定

3. `InteractionFactory`を修正

- `customer_id`と`project_id`を案件がある場合は案件の顧客に紐づけ、案件がない場合は顧客だけに紐づく（単発対応）ように設定
- `assigned_user_id`を顧客の担当者と同じになるように設定

#### 4. DatabaseSeeder を作成

- User / Customer / Project / Interaction をまとめて生成

### 確認内容

- 顧客・案件・案件履歴の新規作成・編集が正常に動作すること
- 必須項目が空欄で登録できないこと
- ログインユーザー以外の顧客・案件が選択肢に出ないこと
- バリデーションエラーが正しく表示されること
- 任意項目が未設定と表示されること
- Factory で生成されたデータの整合性が取れている

### 気づき・課題

- `Interaction`の`project_id`は`nullable`のため、ビュー側で`null`チェックが必要
- 日付項目（`start_date`/`end_date`）は`null`の可能性があるため、`format()`を呼ぶ前に`null`チェックが必須
- `enum`（`status`/`rank`）は必須のため “未設定” 表示は不要だが、将来の仕様変更に備えるなら`fallback`を要検討

---

## 機能名：顧客検索

### 目的

- 該当する顧客情報に素早くアクセスすることで、ユーザーの作業効率を向上させるため

### ブランチ名：**feature/search-customers**

### 実装日：2026-02-23

### 作成・変更・自動生成されたファイル

- `resources/views/customers/index.blade.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）

### 実装内容

- 顧客一覧ページに検索フォームを追加
- `CustomerController@index`に顧客名の部分一致検索ロジックを追加

### 実装手順

1. `customers/index.blade.php`に検索フォームを追加

- 検索フォームの作成
    - `request('keyword')`により検索語の保持
    - `GET`メソッドで`customers.index`に送信
- 検索ボタンの作成
- Tailwind CSS によるスタイル適用

2. ルーティング（resource）で`customers.index`が有効であることを確認

3. `CustomerController@index`を変更

- `$query = Customer::query()`でクエリの土台を作成
- `$request->filled('keyword')`で入力チェック
- `LIKE "%keyword%"` による部分一致検索を追加
- 作成日降順で並べ、20件ずつページネーション

### 確認内容

- 検索フォーム・検索ボタンが正しく表示されること
- 検索語を入力すると該当データのみ表示されること
- 空検索では全顧客が表示されること
- ページネーションと検索が両立していること
- 検索語がフォームに保持されていること

### 気づき・課題

- メール・電話番号・会社名などの文字検索は拡張ブランチで拡張予定
- ステータス・ランク・担当者・作成日などの条件検索は絞り込みブランチで実装予定
- 顧客一覧は「全顧客を表示する」仕様とした
    - 企業での情報共有を優先
    - 担当者は責任者を示すための情報であり、閲覧制限のためのものではない
    - 将来的に権限管理を導入する場合は閲覧制御を要検討

---

## 機能名：顧客検索拡張

### 目的

- 顧客名以外の情報でも検索できるようにすることで、検索精度とユーザーの利便性を向上させるため
- 検索後のページ移動時に検索条件が消えないようにすることで、ユーザー体験を改善するため

### ブランチ名：**feature/search-customers-extended**

### 実装日：2026-02-25

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/CustomerController.php`（更新）
- `resources/views/customers/index.blade.php`（更新）

### 実装内容

- 拡張検索機能を実装
    - メール・電話番号・会社名の部分一致検索の追加
    - OR条件を`function`によりグループ化
- 検索条件付きページネーションを実装

### 実装手順

1. 拡張検索機能を実装

- `CustomerController@index`にメール・電話番号・会社名で検索できるロジックを追加
- OR 条件を function で括ることで、検索条件がひとかたまりとして扱われるようにした

2. 検索条件付きページネーションを実装

- `customers/index.blade.php`のページネーションに`appends(request()->query())`を追加

### 確認内容

- メール・電話番号・会社名で検索できること
- 検索キーワード保持した状態でページ遷移できること
- ページ2以降でも検索結果が正しく維持されること

### 気づき・課題

- AND / OR の優先順位による意図しない SQL を防ぐため、OR 条件は`function`で括るのが基本
- 担当者で検索したい場合は、キーワード検索ではなく「絞り込み（select）」で実装するのが自然（別ブランチで対応予定）
- `query()`は複数のクラスに存在し、意味が異なるので、どのクラスのメソッドか意識するのが大切

---

## 機能名：案件検索

### 目的

- 該当する顧客情報に素早くアクセスすることで、ユーザーの作業効率を向上させるため
- 検索後のページ移動時に検索条件が消えないようにすることで、ユーザー体験を改善するため

### ブランチ名：**feature/search-projects**

### 実装日：2026-02-25

### 作成・変更・自動生成されたファイル

- `resources/views/projects/index.blade.php`（更新）
- `app/Http/Controllers/ProjectController.php`（更新）

### 実装内容

- 案件一覧ページに検索フォームを追加
- `ProjectController@index`に案件名の部分一致検索ロジックを追加
- 検索条件付きページネーションを実装

### 実装手順

#### 1. 検索機能の実装

1. `projects/index.blade.php`に検索フォームを追加

- 検索フォームの作成
    - `request('keyword')`により検索語の保持
    - `GET`メソッドで`projects.index`に送信
- 検索ボタンの作成
- Tailwind CSS によるスタイル適用

2. ルーティング（resource）で`projects.index`が有効であることを確認

3. `ProjectController@index`を変更

- `$query = Customer::query()`でクエリの土台を作成
- `$request->filled('keyword')`で入力チェック
- `LIKE "%{keyword}%"`による部分一致検索を追加
- 作成日降順で並べ、20件ずつページネーション

#### 2. 検索条件付きページネーションを実装

- `projects/index.blade.php`のページネーションに`appends(request()->query())`を追加

### 確認内容

- 検索フォーム・検索ボタンが正しく表示されること
- 案件名を入力すると該当データのみ表示されること
- 空検索では全顧客が表示されること
- 検索語がフォームに保持されていること
- ページ移動しても検索条件が保持されていること
- ページ2以降でも検索結果が正しく維持されること

### 気づき・課題

- 顧客名・担当者名・ステータスなどは絞り込み機能（別ブランチ）で実装予定

---

## 機能名：案件履歴検索

### 目的

- 該当する顧客履歴情報に素早くアクセスすることで、ユーザーの作業効率を向上させるため
- 検索後のページ移動時に検索条件が消えないようにすることで、ユーザー体験を改善するため

### ブランチ名：**feature/search-interactions**

### 実装日：2026-02-25

### 作成・変更・自動生成されたファイル

- `resources/views/interactions/index.blade.php`（更新）
- `app/Http/Controllers/InteractionController.php`（更新）

### 実装内容

- 案件履歴一覧ページに検索フォームを追加
- `InteractionController@index`に内容の部分一致検索ロジックを追加
- 検索条件付きページネーションを実装

### 実装手順

#### 1. 案件履歴検索機能を実装

1. `interactions/index.blade.php`を変更

- 検索フォームの作成
    - `request('keyword')`により検索語の保持
    - `GET`メソッドで`projects.index`に送信
- 検索ボタンの作成
- Tailwind CSS によるスタイル適用

2. ルーティング（resource）で`interactions.index`が有効であることを確認

3. `InteractionController@index`を変更

- `$query = Customer::query()`でクエリの土台を作成
- `$request->filled('keyword')`で入力チェック
- `LIKE "%{keyword}%"`による部分一致検索を追加
- 作成日降順で並べ、20件ずつページネーション

#### 2. 検索条件付きページネーションを実装

- `projects/index.blade.php`のページネーションに`appends(request()->query())`を追加

### 確認内容

- 検索フォーム・検索ボタンが正しく表示されること
- 内容を入力すると該当データのみ表示されること
- 空検索では全顧客が表示されること
- 検索語がフォームに保持されていること
- ページ移動しても検索条件が保持されていること
- ページ2以降でも検索結果が正しく維持されること

### 気づき・課題

- 顧客名・担当者名・対応種別などは絞り込み機能（別ブランチ）で実装予定

---

## 機能名：顧客絞り込み

### 目的

- 顧客一覧から必要な情報を素早く抽出し、業務効率とユーザーの利便性を向上させるため

### ブランチ名：**feature/filter-customers**

### 実装日：2026-02-26 ~ 2026-02-27

### 作成・変更・自動生成されたファイル

- `resources/views/customers/index.blade.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）

### 実装内容

- `customers/index.blade.php`に検索フォーム（ステータス・担当者・作成日用）を追加
- `CustomerController@index`に検索ロジックを追加
- `CustomerController@index`に作成日検索用のバリデーション機能を追加

### 実装手順

#### 1. 絞り込み機能の実装

1. `customers/index.blade.php`に検索フォームを追加

- 検索フォーム（select・日付入力欄）の作成
    - `<select>`でステータス・担当者用を作成
    - `@selected(request() == $key)`により検索語の保持
    - `<input type="date">`で作成日用を作成
    - `request()`により検索語の保持
    - `<label>`で項目名を追加
    - クリアボタンの作成
- Tailwind CSS によるスタイル適用

2. ルーティング（resource）で`customers.index`が有効であることを確認

3. `CustomerController@index`を変更

- `Customer::STATUSES`でステータス、`User::all()`で担当者の選択肢を`customers/index.blade.php`に渡す
- `$request->filled()`で入力チェックを行い、該当すれば`where()`や`whereDate()`で絞り込み検索を追加
- 作成日の`from/to`の値が逆転している場合は入れ替える処理を実装

#### 2. 作成日検索用バリデーションを実装

- `CustomerController@index`を変更
    - `created_from・created_to`に対して`nullable|date`のバリデーションを追加

### 確認内容

- ステータス・担当者・作成日用の検索フォームが正しく表示されること
- 内容を入力すると該当データのみ表示されること
- 空検索では全顧客が表示されること
- 選択された内容がフォームに保持されていること
- 作成日の`from/to`が逆転していても正しく補正されること
- ページ移動しても検索条件が保持されていること
- ページ2以降でも検索結果が正しく維持されること

### 気づき・課題

- `@selected()`を使うことで、フォームの選択状態を保持する方法を理解できた
- 日付検索では`whereDate()`を使うことを学んだ
- `from/to`の逆転処理を実装することで、ユーザーの入力ミスに強い検索機能を作れた
- grid レイアウトを採用することで、検索フォームが崩れにくくなることを学んだ
- 検索フォームにも「アプリを守るための最低限のバリデーション」が必要なケースがあることを理解した

---

## 機能名：案件絞り込み

### 目的

- 案件一覧から必要な情報を素早く抽出し、業務効率とユーザーの利便性を向上させるため

### ブランチ名：**feature/filter-projects**

### 実装日：2026-02-28 ~ 2026-03-01

### 作成・変更・自動生成されたファイル

- `resources/views/projects/index.blade.php`（更新）
- `app/Http/Controllers/ProjectController.php`（更新）

### 実装内容

- `projects/index.blade.php`に検索フォーム（顧客名・ステータス・税抜金額・担当者・期間・作成日用）を追加
- `ProjectController@index`に検索ロジックを追加
- `ProjectController@index`に期間・作成日検索用のバリデーション機能を追加

### 実装手順

#### 1. 顧客名絞り込み機能の実装

1. `ProjectController@index`を変更

- リレーション（`Customer::orderBy()->get()`）を活用して顧客名の選択肢を`projects/index.blade.php`に渡す

2. `projects/index.blade.php`に顧客名用の検索フォームを追加

- 顧客名用の検索フォームを追加
    - 顧客名用検索フォームを`<select>`で作成
    - `@selected()`で検索語を保持

3. `ProjectController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`where()`で検索条件を追加

#### 2. ステータス絞り込み機能の実装

1. `ProjectController@index`を変更

- 定数（`Project::STATUSES`）を活用してステータス用の選択肢を`projects/index.blade.php`に渡す

2. `projects/index.blade.php`にステータスの検索フォームを追加

- ステータス用の検索フォームを追加
    - ステータス用検索フォームを`<select>`で作成
    - `@selected()`で検索語を保持

3. `ProjectController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`where()`で検索条件を追加

#### 3. 担当者絞り込み機能の実装

1. `ProjectController@index`を変更

- リレーション（`User::orderBy()->get()`）を活用して担当者用の選択肢を`projects/index.blade.php`に渡す

2. `projects/index.blade.php`に担当者の検索フォームを追加

- 担当者用の検索フォームを追加
    - 担当者用検索フォームを`<select>`で作成
    - `@selected()`で検索語を保持

3. `ProjectController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`where()`で検索条件を追加

#### 4. 税抜金額絞り込み機能の実装

1. `projects/index.blade.php`に税抜金額用の検索フォームを追加

- 税抜金額用の検索フォームを追加
    - 税抜金額用検索フォームを`<input>`で作成
    - `request()`で検索語を保持

2. `ProjectController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`where()`で検索条件を追加
- 検索範囲に「最高金額～最低金額」と入力されている場合、最高金額と最低金額を入れ替える処理を実装

#### 5. 期間絞り込み機能の実装

1. `projects/index.blade.php`に期間用の検索フォームを追加

- 期間用の検索フォームを追加
    - 期間用検索フォームを`<date>`で作成
    - `request()`で検索語を保持

2. `ProjectController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`whereDate()`で検索条件を追加
- 検索範囲に「終了日～開始日」と入力されている場合、終了日と開始日を入れ替える処理を実装

#### 6. 作成日絞り込み機能の実装

1. `projects/index.blade.php`に作成用の検索フォームを追加

- 作成用の検索フォームを追加
    - 作成用検索フォームを`<date>`で作成
    - `request()`で検索語を保持

2. `ProjectController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`whereDate()`で検索条件を追加
- 検索範囲に「終了日～開始日」と入力されている場合、終了日と開始日を入れ替える処理を実装

#### 7. バリデーション機能の実装

1. `ProjectController@index`を変更

- 期間・作成日（`start_form/end_to/created_from/created_to`）に対して`nullable|date`のバリデーションを追加

#### 8. UI の調整

- グリッドレイアウトで項目を整理
- `<label>`で項目名を追加
- クリアボタンを追加
- ダークモード対応
- Tailwind CSS によるスタイル適用

### 確認内容

- 各検索フォームが正しく表示されること
- 入力した条件で案件一覧が正しく絞り込まれて表示されること
- 空検索では全顧客が表示されること
- 入力した検索条件がフォームに保持されること
- 金額・期間・作成日の範囲が逆転していても補正されること
- ページネーションで検索条件が保持されること
- ページ 2 以降でも検索結果が維持されること

### 気づき・課題

- 担当者を仮名順で並べるため、`users`テーブルに`kana`カラム追加を要検討
- 税抜金額・期間の「未設定」案件を検索対象に含めるオプションを要検討（管理者向け）
- `ProjectController@index`が肥大化しているため、以下の改善を要検討
    - モデルスコープ化
    - 共通処理の関数化
    - 配列ループによる条件追加の簡略化
    - FormRequest の導入によるバリデーション分離

---

## 機能名：案件履歴絞り込み

### 目的

- 案件履歴一覧から必要な情報を素早く抽出し、業務効率とユーザーの利便性を向上させるため

### ブランチ名：**feature/filter-interactions**

### 実装日：2026-03-01 ~ 2026-03-02

### 作成・変更・自動生成されたファイル

- `resources/views/interactions/index.blade.php`（更新）
- `app/Http/Controllers/InteractionController.php`（更新）

### 実装内容

- `interactions/index.blade.php`に検索フォーム（対応日時・対応種別・案件名・顧客名・担当者用）を追加
- `InteractionController@index`に各種絞り込みロジックを追加
- `InteractionController@index`に対応日時検索用のバリデーションを追加
- `interactions/index.blade.php`の検索フォームのUI を顧客一覧・案件一覧画面と同じデザインに統一

### 実装手順

#### 1. 対応日時絞り込み機能の実装

1. `interactions/index.blade.php`に作成用の検索フォームを追加

- 対応日時用の検索フォームを追加
    - 対応日時用検索フォームを`<date>`で作成
    - `request()`で検索語を保持

2. `InteractionController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`where()`で検索条件を追加
- 検索範囲に「終了日～開始日」と入力されている場合、終了日と開始日を入れ替える処理を実装

#### 2. 対応種別絞り込み機能の実装

1. `InteractionController@index`を変更

- 定数（`Interaction::TYPE`）を活用して対応種別用の選択肢を`interactions/index.blade.php`に渡す

2. `interactions/index.blade.php`に対応種別用の検索フォームを追加

- 対応種別用の検索フォームを追加
    - 対応種別用検索フォームを`<select>`で作成
    - `@selected()`で検索語を保持

3. `InteractionController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`where()`で検索条件を追加

#### 3. 案件名絞り込み機能の実装

1. `interactions/index.blade.php`に案件名用の検索フォームを追加

- 案件名用の検索フォームを追加
    - 案件名用検索フォームを`<input type="text">`で作成
    - `request()`で検索語を保持

2. `InteractionController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`whereHas()`で検索条件を追加

#### 4. 顧客名絞り込み機能の実装

1. `InteractionController@index`を変更

- リレーション（`Customer::orderBy()->get()`）を活用して顧客名の選択肢を`interactions/index.blade.php`に渡す

2. `interactions/index.blade.php`に顧客名用の検索フォームを追加

- 顧客名用の検索フォームを追加
    - 顧客名用検索フォームを`<select>`で作成
    - `@selected()`で検索語を保持

3. `InteractionsController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`where()`で検索条件を追加

#### 5. 担当者絞り込み機能の実装

1. `InteractionController@index`を変更

- リレーション（`User::orderBy()->get()`）を活用して担当者用の選択肢を`interactions/index.blade.php`に渡す

2. `interactions/index.blade.php`に担当者の検索フォームを追加

- 担当者用の検索フォームを追加
    - 担当者用検索フォームを`<select>`で作成
    - `@selected()`で検索語を保持

3. `InteractionController@index`を変更

- 入力チェック（`$request->filled()`）を行い、入力があれば`where()`で検索条件を追加

#### 6. バリデーション機能の実装

1. `InteractionController@index`を変更

- 対応種別（`interacted_from/interacted_to`）に対して`nullable|date`のバリデーションを追加

#### 7. UI の調整

- 外枠ボックス（背景色・枠線・角丸・padding）を追加
- 「検索条件」タイトル行を追加
- グリッドレイアウトで項目を整列
- `<label>`で項目名を追加
- クリアボタンを追加
- ダークモード対応
- Tailwind CSS によるスタイル適用

### 確認内容

- 各検索フォームが正しく表示されること
- 入力した条件で案件履歴が正しく絞り込まれて表示されること
- 空検索では全顧客が表示されること
- 入力した検索条件がフォームに保持されること
- 対応日時の範囲が逆転していても補正されること
- ページネーションで検索条件が保持されること
- ページ 2 以降でも検索結果が維持されること
- UI が顧客一覧・案件一覧画面と統一されていること

### 気づき・課題

- 対応日時は`datetime-local`だと細かすぎるため、`date`の方が実務に合っていると感じた
- 案件名は`<select>`だと件数増加時に探しづらいため、キーワード検索が適切
- リレーション検索には`whereHas()`を使う必要があることを理解した
- `InteractionController@index`が肥大化しているため、以下の改善を要検討
    - モデルスコープ化
    - 共通処理の関数化
    - 配列ループによる条件追加の簡略化
    - FormRequest の導入によるバリデーション分離
- 検索フォームのUI が複雑化してきたため、将来的には「検索条件の折りたたみ（開閉）」を要検討

---

## 機能名：顧客一覧並び替え

### 目的

- 案件履歴一覧から必要な情報を素早く抽出し、業務効率とユーザーの利便性を向上させるため

### ブランチ名：**feature/sort-customers**

### 実装日：2026-03-03 ~ 2026-03-05

### 作成・変更・自動生成されたファイル

- `resources/views/customers/index.blade.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）

### 実装内容

- `customers/index.blade.php`の各カラム（顧客名・メール・会社名・作成日）にソートリンクを追加
- `customers/index.blade.php`にソートUI （▲/▼）を追加
- `customers/index.blade.php`に検索条件保持ソート機能を追加
- `CustomerController@index`にソートロジックを実装
    - ソート可能なカラム一覧（ホワイトリスト）を追加

### 実装手順

各カラムを下記のとおり実装

#### 1. ソート機能（昇順）の実装

1. `customers/index.blade.php`のソートリンクを追加

- `route()`の第2引数に`sort`と`direction`を設定してクエリパラメーターを送信

2. `CustomerController@index`を変更

- クエリパラメーターの`sort`の値チェック（`$request->get('sort')`）を行い、値が一致すれば`orderBY()`でソート条件を追加

#### 2. ソート機能（昇順 → 降順の切り替え）の実装

1. `customers/index.blade.php`のソートリンクを追加

- `route()`の第2引数の`direction`に`request('direction') == 'asc' ? 'desc' : 'asc'`を設定してクエリパラメーターを送信

2. `CustomerController@index`を変更

- クエリパラメーターの`sort`の値チェック（`$request->get('sort')`）を行い、値が一致すれば`direction`の値を取得して`orderBY()`でソート条件を追加

#### 3. ソートUI（▲▼）の調整

1. `customers/index.blade.php`のソートUI を追加

- `direction`が`asc`の場合は「▲」、`direction`が`desc`の場合は「▼」と表示

#### 4. 検索条件保持ソート機能の実装

1. `customers/index.blade.php`の変更

- `route()`のクエリパラメーターに検索条件（`array_merge(request()->query())`）を追加

#### 5. ホワイトリスト化の実装

1. `CustomerController@index`を変更

- `$sortable`配列を作成して、ホワイトリスト化
- クエリパラメーターの`sort`の値チェック（`in_array()`）を行い、値があれば`orderBY()`でソート条件を追加
- 2つ目のカラム以降の実装では、`$sortable`にカラム名を追加するのみ

### 確認内容

- 各カラムにソートリンクが設定されていること
- ソートが正しく実行され表示されること
- 昇順・降順が正しく切り替えられること
- ソートUI （▲/▼）が正しく表示されること
- ホワイトリスト以外のカラムではソートされないこと
- 検索条件を保持したままソートされること
- ページネーションで検索・ソート条件が保持されること
- ページ 2 以降でも検索・ソート結果が維持されること

### 気づき・課題

- ルートパラメーター（URL のパスの一部に埋め込まれる値・必須）とクエリパラメーター（URL の ? 以降に付く追加情報・任意）の違いについて理解できた
- ソート機能の基本構造（リンク → クエリ → コントローラー → UI）が理解できた
- ホワイトリスト化により安全なソート実装ができることを学んだ
- 検索条件保持ソートの実装パターンを習得した

---

## 機能名：案件一覧並び替え

### 目的

- 案件一覧から必要な情報を素早く抽出し、業務効率とユーザーの利便性を向上させるため

### ブランチ名：**feature/sort-projects**

### 実装日：2026-03-05 ~ 2026-03-06

### 作成・変更・自動生成されたファイル

- `resources/views/projects/index.blade.php`（更新）
- `app/Http/Controllers/ProjectController.php`（更新）

### 実装内容

- `projects/index.blade.php`の変更
    - 各カラム（案件名・顧客名・税抜金額・作成日）にソートリンクを追加
    - ソートUI （▲/▼）を追加
    - 検索条件保持ソート機能を追加
- `projectController@index`の変更
    - ソートロジックを追加
    - ソート可能なカラム一覧（ホワイトリスト）を作成
    - 顧客名ソート時に JOIN を実行し、外部テーブルのカラムをエイリアス付きで取得
    - JOIN を使用するため、検索条件のカラムにはテーブル名を明示

### 実装手順

各カラムを下記のとおり実装

#### 1. ソート機能（昇順）の実装

1. `projects/index.blade.php`のソートリンクを追加

- `route()`の第2引数に`sort`と`direction`を設定してクエリパラメーターを送信

2. `ProjectController@index`にソート処理を追加

- `$request->get('sort')`の値を確認し、ホワイトリストに含まれる場合のみ`orderBy()`を実行
- 外部テーブルのカラムでソートする場合は JOIN を行い、エイリアスを付けて取得

#### 2. ソート機能（昇順 → 降順の切り替え）の実装

1. `projects/index.blade.php`のソートリンクを追加

- `direction`に`request('direction') === 'asc' ? 'desc' : 'asc'`を設定し、クリックごとに昇順⇆降順を切り替え

#### 3. ソートUI（▲▼）の調整

1. `projects/index.blade.php`のソートUI を追加

- `direction`が`asc`の場合は「▲」、`direction`が`desc`の場合は「▼」を表示

#### 4. 検索条件保持ソート機能の実装

1. `projects/index.blade.php`の変更

- `route()`の第2引数に検索条件（`array_merge(request()->query())`）を追加

#### 5. ホワイトリスト化の実装

1. `ProjectController@index`を変更

- `$sortable`配列を作成し、ソート可能なカラムを限定
- `in_array()`で検証し、安全なカラムのみ`orderBy()`を実行
- 新しいカラムを追加する場合は`$sortable`に追加するだけで対応可能

### 確認内容

- 各カラムにソートリンクが設定されていること
- ソートが正しく実行され表示されること
- 昇順・降順が正しく切り替えられること
- ソートUI （▲/▼）が正しく表示されること
- ホワイトリスト以外のカラムではソートされないこと
- 検索条件を保持したままソートされること
- ページネーションで検索・ソート条件が保持されること
- ページ 2 以降でも検索・ソート結果が維持されること

### 気づき・課題

- `get()`の第2引数にデフォルト値を設定できるため、`if`の`else`を省略できる
- ビューでは`request()->query()`、コントローラーでは`$request->query()`を使用する
- 外部キーのソートでは JOIN が必要で、外部テーブルのカラムをエイリアスで取得する
- JOIN を使用する場合、検索条件のカラム名にはテーブル名を明示する必要がある（曖昧なカラム名による SQL エラーを防ぐため）

---

## 機能名：案件履歴一覧並び替え

### 目的

- 案件履歴一覧から必要な情報を素早く抽出し、業務効率とユーザーの利便性を向上させるため

### ブランチ名：**feature/sort-interactions**

### 実装日：2026-03-08 ~ 2026-03-09

### 作成・変更・自動生成されたファイル

- `resources/views/interactions/index.blade.php`（更新）
- `app/Http/Controllers/InteractionController.php`（更新）

### 実装内容

- `interactions/index.blade.php`の変更
    - 各カラム（対応日時・顧客名）にソートリンクを追加
    - `direction`をクリックごとに反転させるロジックを追加
    - ソートUI （▲/▼）を追加
    - 検索条件保持ソート機能を追加
- `InteractionController@index`の変更
    - ソートロジックを追加
    - ソート可能なカラム一覧（ホワイトリスト）を作成
    - `direction`を`asc / desc`のみに制限（ホワイトリスト化）
    - 顧客名ソート時に JOIN を実行し、外部テーブルのカラムをエイリアス付きで取得
    - JOIN を使用するため、検索条件のカラムにはテーブル名を明示

### 実装手順

各カラムを下記のとおり実装

#### 1. ソート機能（昇順）の実装

1. `interactions/index.blade.php`のソートリンクを追加

- `route()`の第2引数に`sort`と`direction`を設定してクエリパラメーターを送信

2. `InteractionController@index`にソート処理を追加

- `$request->get('sort')`の値を確認し、ホワイトリストに含まれる場合のみ`orderBy()`を実行
- 外部テーブルのカラムでソートする場合は JOIN を行い、エイリアスを付けて取得

#### 2. ソート機能（昇順 → 降順の切り替え）の実装

1. `interactions/index.blade.php`のソートリンクを追加

- `direction`に`request('direction') === 'asc' ? 'desc' : 'asc'`を設定し、クリックごとに昇順⇆降順を切り替え

#### 3. ソートUI（▲▼）の調整

1. `interactions/index.blade.php`のソートUI を追加

- `direction`が`asc`の場合は「▲」、`direction`が`desc`の場合は「▼」を表示

#### 4. 検索条件保持ソート機能の実装

1. `interactions/index.blade.php`の変更

- `route()`の第2引数に検索条件（`array_merge(request()->query())`）を追加

#### 5. ホワイトリスト化の実装

1. `InteractionController@index`を変更

- `$sortable`配列を作成し、ソート可能なカラムを限定
- `$direction = $direction === 'asc' ? 'asc' : 'desc'`を設定
- `in_array()`で検証し、安全なカラムのみ`orderBy()`を実行
- 新しいカラムを追加する場合は`$sortable`に追加するだけで対応可能

### 確認内容

- 各カラムにソートリンクが設定されていること
- ソートが正しく実行され表示されること
- 昇順・降順が正しく切り替えられること
- ソートUI （▲/▼）が正しく表示されること
- ホワイトリスト以外のカラムではソートされないこと
- 検索条件を保持したままソートされること
- ページネーションで検索・ソート条件が保持されること
- ページ 2 以降でも検索・ソート結果が維持されること

### 気づき・課題

- URL の直入力対策として、`direction`のホワイトリスト化も必要だと理解した

---

## 機能名：検索ロジックの共通化

### 目的

- `Controller@index()`の肥大化を解消して、可読性を向上させるため
- 検索条件を`Scope`としてモデルで共通化することで、再利用性を向上させるため
- コントローラの責務を「検索条件の適用」と「ビューへのデータ受け渡し」に限定し、テスト容易性とバグ発生率を低減させるため

### ブランチ名：**refactor/search-scopes**

### 実装日：2026-03-11 ~ 2026-03-13

### 作成・変更・自動生成されたファイル

- `app/Models/Customer.php`（更新）
- `app/Models/Project.php`（更新）
- `app/Models/Interaction.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）
- `app/Http/Controllers/ProjectController.php`（更新）
- `app/Http/Controllers/InteractionController.php`（更新）

### 実装内容

- `Customer / Project / Interaction`モデルに検索用`Scope`を追加
    - 各カラムごとの検索`Scope`を追加
    - 複数の検索条件をまとめて適用する`scopeFilter()`を追加
- 各コントローラーの検索ロジックを`Scope`呼び出しに置き換え
    - fat controller を解消し、検索ロジックをモデル側へ移動

### 実装手順

1. モデルに複数条件をまとめる`scopeFilter()`を追加

- `$query->filter($request)`で全検索条件を適用できるようにする

2. モデルに検索用`Scope`を追加

- カラムごとに`scope〇〇()`を実装
- 日付範囲・部分一致・外部キー検索などをモデル側に集約

3. コントローラーの検索ロジックを`Scope`呼び出しに置き換え

- `$query = Model::query()->filter($request);`に一本化

### 確認内容

- 入力した条件で一覧が正しく検索されて表示されること
- 空検索では全顧客が表示されること
- 日付の範囲が逆転していても補正されること
- ページネーションで検索条件が保持されること
- ページ 2 以降でも検索結果が維持されること

### 気づき・課題

- `Scope`を使うことで、検索ロジックをモデルに集約するメリット（再利用性・保守性・安全性）が理解できた
- コントローラが細くなり、責務分離の重要性を実感した
- 今後は別ブランチで`FormRequest`や`Trait`化などを実装予定

---

## 機能名：ソート処理の共通化

### 目的

- 各一覧画面（顧客・案件・案件履歴）のソート処理を共通化し、保守性・再利用性を向上させるため
- コントローラからソートロジックを排除し、モデル側に設定を集約することで責務分離と可読性を向上させるため

### ブランチ名：**refactor/sortable-trait**

### 実装日：2026-03-13 ~ 2026-03-15

### 作成・変更・自動生成されたファイル

- `app/Http/Traits/Sortable.php`（新規）
- `app/Models/Customer.php`（更新）
- `app/Models/Project.php`（更新）
- `app/Models/Interaction.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）
- `app/Http/Controllers/ProjectController.php`（更新）
- `app/Http/Controllers/InteractionController.php`（更新）

### 実装内容

- `SortableTrait`を実装
    - `app/Http/Traits/Sortable.php`を作成
    - `scopeSort()`を追加
    - ホワイトリスト化・デフォルトソート・join 対応を実装
- `Customer / Project / Interaction`モデルにソート設定を追加
    - `$sortable`（ホワイトリスト）を追加
    - `$defaultSort / $defaultDirection`を追加
    - `$sortableJoins`（join が必要なソートキー）を追加
- 各コントローラの`index()`のソート処理を`Scope`呼び出しに置き換え
    - `index()`内のソートロジックをすべて削除
    - `$query->sort($request)`に置き換え

### 実装手順

#### 1. トレイトを活用した最小限のソート機能を実装

1. `SortableTrait`を作成

- `scopeSort()`を追加して`orderBy()`を共通化

2. 各モデルに「ソート設定」を追加

- `use App\Traits\Sortable;`と`use Sortable;`を追加

3. 各 Controller の index のソート処理を`Scope`呼び出しに置き換え

- `query()->sort($request);`に変更

#### 2. ホワイトリスト化の実装

1. 各モデルに`$sortable`を追加

- ソート可能なカラムを明示的に定義（SQL インジェクション対策として安全性を確保）
- 新しいカラムを追加する場合は`$sortable`に追加するだけで対応可能

2. Trait 側でホワイトリストチェック

- `in_array()`による検証
- `direction`の安全化（`asc / desc` のみ許可）

#### 3. デォルトソートの追加

1. 各モデルにデフォルトソート値を追加

- `$defaultSort`と`$defaultDirection`を追加

2. Trait 側でデフォルトソートを適用

- `$request->get('sort', $this->defaultSort)`を追加
- ホワイトリスト外の場合はデフォルトソートを適用

#### 4. join 対応

1. 各モデルに`$sortableJoins`を追加

- join が必要なソートキーをモデル側で定義
- 設定をモデルに集約

2. Trait 側で join を自動適用

- `array_key_exists($sort, $sortableJoins)`で判定
- `leftJoin()`と`select()`を自動実行
- join 後にソートを適用

### 確認内容

- ソートが正しく実行され表示されること
- 昇順・降順が正しく切り替えられること
- ホワイトリスト以外ではソートされないこと
- join 対応カラム（customer_kana）が正しくソートされること

### 気づき・課題

- ページネーションや検索条件の共通化（Trait 化）を要検討

---

## 機能名：範囲入れ替え処理の共通化

### 目的

- 各モデルのスコープ内の範囲入れ替え処理を共通化し、保守性・再利用性を向上させるため
- 各モデルから範囲入れ替えロジックを排除し、トレイト化することで責務分離と可読性を向上させるため

### ブランチ名：**refactor/range-normalizer**

### 実装日：2026-03-15

### 作成・変更・自動生成されたファイル

- `app/Traits/RangeNormalizer.php`（新規）
- `app/Models/Customer.php`（更新）
- `app/Models/Project.php`（更新）
- `app/Models/Interaction.php`（更新）

### 実装内容

- Trait の実装
    - `app/Http/Traits/RangeNormalizer.php`を作成
    - `normalizerRange()`を追加
- `Customer / Project / Interaction`モデルを変更
    - 各モデルに`use RangeNormalizer;`を追加
    - スコープ内の入れ替え処理を`normalizeRange()`に置き換え

### 実装手順

1. 範囲正規化用の Trait を作る

- `app/Http/Traits/RangeNormalizer.php`を作成
- `normalizeRange()`を追加

2. 各モデルに Trait を組み込み、スコープの「入れ替え処理」を Trait メソッドに置き換える

- `use App\Traits\RangeNormalizer;`と`use RangeNormalizer;`を追加
- `$this->normalizeRange()`に変更

### 確認内容

- 入力した条件で一覧が正しく検索されて表示されること
- 空検索では全顧客が表示されること
- 日付の範囲が逆転していても補正されること

### 気づき・課題

- 今後、範囲検索が増えても Trait を使うだけで対応できるため、拡張性が高くなった

---

## 機能名：バリデーションのフォームリクエスト化

### 目的

- `Controller`のバリデーションを FormRequest クラスへ分離することで責務分離と可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/form-request**

### 実装日：2026-03-16 ~ 2026-03-17

### 作成・変更・自動生成されたファイル

- `app/Request/CustomerSearchRequest`（新規）
- `app/Request/ProjectSearchRequest`（新規）
- `app/Request/InteractionSearchRequest`（新規）
- `app/Request/CustomerStoreRequest`（新規）
- `app/Request/ProjectStoreRequest`（新規）
- `app/Request/InteractionStoreRequest`（新規）
- `app/Request/CustomerUpdateRequest`（新規）
- `app/Request/ProjectUpdateRequest`（新規）
- `app/Request/InteractionUpdateRequest`（新規）
- `app/Http/Controllers/CustomerController.php`（更新）
- `app/Http/Controllers/ProjectController.php`（更新）
- `app/Http/Controllers/InteractionController.php`（更新）

### 実装内容

- FormRequest クラスの実装
    - 各リソース（`Customer / Project / Interaction`）に`SearchRequest`・`StoreRequest`・`UpdateRequest`を追加
    - コントローラ内のバリデーションロジックを`FormRequest`に移植
- コントローラの変更
    - メソッドの引数を FormRequest クラスに変更
    - `request->validated()`を使用して安全なデータのみを取得

### 実装手順

1. FormRequest クラスを作成

    ```sh
    php artisan make:request XxxSearchRequest
    php artisan make:request XxxStoreRequest
    php artisan make:request XxxUpdateRequest
    ```

2. FormRequest クラスを変更

- `authorize()`の返り値を`true`に変更
- コントローラのバリデーションルールを`rules()`に移植

3. コントローラをリファクタリング

- メソッドの引数をFormRequest クラスに変更
- `$request->validated()`に修正
- 直書きしていたコントローラのバリデーションを削除

### 確認内容

- バリデーションエラーメッセージが正しく表示されること
- 新規登録・更新処理が行われ、DBに保存・一覧・詳細ページに表示されること
- 検索画面で不正な日付が入力された場合、正しく弾かれること

### 気づき・課題

- FormRequest を使う場合は`$request->validate()`ではなく`$request->validated()`を使う
  → これにより「バリデーション済みの安全なデータのみ」を扱える
- `index()`の検索処理では`validated()`は不要
  → 保存処理ではないため、Request オブジェクトのまま`filter() / sort()`に渡すのが正しい
- 顧客ID・担当者IDなど、画面から変更させない値はコントローラ側で固定する
  → FormRequest にビジネスロジックを入れない設計が保てる

---

## 機能名：フラッシュメッセージのコンポーネント化

### 目的

- 各画面に重複して記述していたフラッシュメッセージ表示部分をコンポーネントとして共通化して分離することで、責務分離と可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/component-flash-message**

### 実装日：2026-03-19

### 作成・変更・自動生成されたファイル

- `resources/views/components/alert.blade.php`（新規）
- `resources/views/customers/index.blade.php`（更新）
- `resources/views/customers/show.blade.php`（更新）
- `resources/views/projects/index.blade.php`（更新）
- `resources/views/projects/show.blade.php`（更新）
- `resources/views/interactions/index.blade.php`（更新）
- `resources/views/interactions/show.blade.php`（更新）

### 実装内容

- フラッシュメッセージ表示用の Blade コンポーネントを作成
- 顧客・案件・案件履歴の一覧・詳細画面で、従来のフラッシュメッセージ部分をコンポーネントに置換

### 実装手順

1. コンポーネントの作成

- `resources/views/components/alert.blade.php`の作成
- `@props()`で必要な引数の受け取りを定義
- `@if($message)`でフラッシュメッセージの表示を制御

2. 各 blade ファイルのフラッシュメッセージの部分を置換

- 既存の `@if(session()) ... @endif`ブロックを削除
- `<x-alert :message="session()" />` のようにコンポーネント呼び出しに置換
- 顧客・案件・案件履歴の一覧・詳細画面すべてで同様の置換を実施

### 確認内容

- 顧客・案件・案件履歴の一覧・詳細画面で、従来どおりフラッシュメッセージが表示されること

### 気づき・課題

- Blade コンポーネントの記述方法・呼び出し方・データの受け渡しを理解できた
- セッションのキーと値の保存・取得の流れ（コントローラー → セッション → View）を改めて整理できた

---

## 機能名：ボタンのコンポーネント化

### 目的

- 各画面に重複して記述していたボタン表示部分をコンポーネントとして共通化して分離することで、責務分離と可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/component-button**

### 実装日：2026-03-22 ~ 2026-03-24

### 作成・変更・自動生成されたファイル

- `resources/views/components/primary.blade.php`（新規）
- `resources/views/components/secondary.blade.php`（新規）
- `resources/views/components/danger.blade.php`（新規）
- `resources/views/customers/index.blade.php`（更新）
- `resources/views/customers/show.blade.php`（更新）
- `resources/views/customers/create.blade.php`（更新）
- `resources/views/customers/edit.blade.php`（更新）
- `resources/views/projects/index.blade.php`（更新）
- `resources/views/projects/show.blade.php`（更新）
- `resources/views/projects/create.blade.php`（更新）
- `resources/views/projects/edit.blade.php`（更新）
- `resources/views/interactions/index.blade.php`（更新）
- `resources/views/interactions/show.blade.php`（更新）
- `resources/views/interactions/create.blade.php`（更新）
- `resources/views/interactions/edit.blade.php`（更新）

### 実装内容

- `primary/secondary/danger`の3種類のボタンの Blade コンポーネントを作成
- 顧客・案件・案件履歴の一覧・詳細・新規登録・編集画面で、従来のボタン部分をコンポーネントに置換

### 実装手順

1. コンポーネントの作成

- `resources/views/components/xxx.blade.php(primary/secondary/danger)`の作成
- `@props()`で必要な引数の受け取りを定義
- `@php`でTailwind CSS の class を定義
- `@if($href)`で`<a>`と`<button>`に切り替えるロジックを実装

2. 各 blade ファイルのボタン部分を置換

- 既存の`<a>/<button>`を削除
- `<x-button.xxx>`のようにコンポーネント呼び出しに置換
- 顧客・案件・案件履歴の一覧・詳細・新規登録・編集画面すべてで同様の置換を実施

### 確認内容

- 顧客・案件・案件履歴の一覧・詳細・新規登録・編集画面で、従来どおりボタンが表示されること
- ボタンをクリックした際に、遷移・フォーム送信などの挙動が従来と変わらないこと
- ボタンのスタイル（色・サイズ・ホバー時の挙動）が統一されていること

### 気づき・課題

- Blade コンポーネントで `<a>` と `<button>` を切り替える実装パターンを理解できた
- Tailwind CSS のクラスをコンポーネント側で統一管理することで、UI の一貫性が保ちやすくなると実感した

---

## 機能名：入力フォームコンポーネントの作成

### 目的

- 各画面に重複して記述していたフォーム要素をコンポーネントとして共通化し、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**feat/form-components**

### 実装日：2026-03-27 ~ 2026-03-30

### 作成・変更・自動生成されたファイル

- `resources/views/components/field.blade.php`（新規）
- `resources/views/components/input.blade.php`（新規）
- `resources/views/components/select.blade.php`（新規）
- `resources/views/components/textarea.blade.php`（新規）

### 実装内容

- フォーム共通枠（`field`コンポーネント）の作成
    - ラベル・必須マーク・help・エラー表示を共通化
    - id の自動補完、エラー判定、help/error の ID 生成を実装
- 入力欄コンポーネント（`input/select/textarea`）の作成
    - `old()`による値復元
    - `aria`属性の付与
    - Tailwind の共通スタイル適用
    - `<x-field>`を利用して外枠 UI を統一

### 実装手順

1. フォーム共通部分のコンポーネントを作成

- ラベル表示・必須マーク・help テキスト・エラーメッセージなど「入力欄の外側の共通 UI」を担当するコンポーネントを作成
- `@props()`で`name/id/label/required/help`を受け取る
- `$id`の自動補完（`id`未指定時は`name`を使用）
- `$errors`を利用したエラー表示
- `help`と`error`に対応した`id="xxx-help"/id="xxx-error"`の付与

2. フォーム部品のコンポーネントを作成

- 共通の実装ポイント
    - `@props()`で必要な引数を受け取る
    - `old()`を優先した値の復元処理
    - エラー時の`aria-invalid`付与
    - help/error に応じた`aria-describedby`の生成
    - `<x-field>`を利用して外枠の UI を共通化
    - Tailwind CSS による統一デザイン
- `input.blade.php`
    - `type/placeholder/value`を柔軟に指定可能
- `select.blade.php`
    - `options`（連想配列）を`props`で受け取り、ループで表示
    - 空の「選択してください」オプションをデフォルトで表示
- `textarea.blade.php`
    - `rows`を`props`で指定可能（デフォルト 4）

### 確認内容

- 既存画面に影響が出ていないこと（このブランチでは置換を行わないため）

### 気づき・課題

- コンポーネント化により、フォーム UI の統一が容易になった
- `aria`属性の付与によりアクセシビリティが向上した
- textarea の高さは rows と Tailwind のどちらでも調整可能
- 今後、画面ごとのフォーム置換は別ブランチで行う予定

---

## 機能名：顧客新規登録画面のコンポーネント化

### 目的

- 顧客新規登録画面で重複して記述していたフォーム要素をコンポーネントとして共通化し、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/customer-create-form**

### 実装日：2026-03-30

### 作成・変更・自動生成されたファイル

- `resources/views/customers/create.blade.php`（更新）

### 実装内容

- 従来のフォーム部分をコンポーネントに置換

### 実装手順

1. 既存の`<label>/<input>/<select>/<textarea>/@error`を削除
2. 各項目を`<x-xxx>`のように対応するコンポーネントに置換

### 確認内容

- 従来どおり入力フォームが表示されること
- `old()`による入力値の復元が正しく動作すること
- バリデーションエラー時にエラーメッセージが表示されること
- `aria-invalid/aria-describedby`が正しく付与されていること（アクセシビリティ）
- フォーム送信時の挙動が従来と変わらないこと

### 気づき・課題

- コンポーネント化により`create.blade.php`の記述量が大幅に減り、可読性が向上した
- ラベル・エラー表示・help の UI が統一され、画面間のデザイン差異が解消された

---

## 機能名：顧客編集画面のコンポーネント化

### 目的

- 顧客編集画面で重複して記述していたフォーム要素をコンポーネントとして共通化し、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/customer-edit-form**

### 実装日：2026-03-31 ~ 2026-04-01

### 作成・変更・自動生成されたファイル

- `resources/views/customers/edit.blade.php`（更新）
  ※ コンポーネント（x-input / x-select / x-textarea / x-field）は既存のものを使用

### 実装内容

- 従来のフォーム部分をコンポーネントに置換

### 実装手順

1. 既存の`<label>/<input>/<select>/<textarea>/@error`を削除
2. 各項目を`<x-xxx>`のように対応するコンポーネントに置換

### 確認内容

- 従来どおり入力フォームが表示されること
- `old()`が優先され、未入力時は`$customer->xxx`が表示されること
- バリデーションエラー時にエラーメッセージが表示されること
- `aria-invalid/aria-describedby`が正しく付与されていること（アクセシビリティ）
- フォーム送信時の挙動が従来と変わらないこと

### 気づき・課題

- コンポーネント化により`edit.blade.php`の記述量が大幅に減り、可読性が向上した
- ラベル・エラー表示・help の UI が統一され、画面間のデザイン差異が解消された

---

## 機能名：案件新規登録画面のコンポーネント化

### 目的

- 案件新規登録画面で重複して記述していたフォーム要素をコンポーネントとして共通化し、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/project-create-form**

### 実装日：2026-04-02

### 作成・変更・自動生成されたファイル

- `resources/views/projects/create.blade.php`（更新）
- `app/Http/Controllers/ProjectController.php`（更新）
  ※ コンポーネント（x-input / x-select / x-textarea / x-field）は既存のものを使用

### 実装内容

- 従来のフォーム部分をコンポーネントに置換

### 実装手順

1. ProjectController@create の変更

- 顧客名の選択肢を`pluck('name', 'id')`に変更し、`<x-select>`が扱いやすい 連想配列形式（id => name）に整形

2. `create.blade.php`の変更

- 既存の`<label>/<input>/<select>/<textarea>/@error`を削除
- 各項目を`<x-xxx>`のように対応するコンポーネントに置換

### 確認内容

- 従来どおり入力フォームが表示されること
- `old()`による入力値の復元が正しく動作すること
- バリデーションエラー時にエラーメッセージが表示されること
- `aria-invalid/aria-describedby`が正しく付与されていること（アクセシビリティ）
- フォーム送信時の挙動が従来と変わらないこと

### 気づき・課題

- コンポーネント化により`create.blade.php`の記述量が大幅に減り、可読性が向上した
- ラベル・エラー表示・help の UI が統一され、画面間のデザイン差異が解消された
- Collection と連想配列の違いを理解できた
  → Eloquent の結果は Collection
  → select の options には連想配列が必要
- `pluck()`を使うことで、Collection を「id => name」形式の連想配列に変換できることを学んだ

---

## 機能名：案件編集画面のコンポーネント化

### 目的

- 案件編集画面で重複して記述していたフォーム要素をコンポーネントとして共通化し、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/project-edit-form**

### 実装日：2026-04-03 ~ 2026-04-04

### 作成・変更・自動生成されたファイル

- `resources/views/projects/edit.blade.php`（更新）
- `resources/views/components/input.blade.php`（更新）
- `resources/views/components/select.blade.php`（更新）
  ※ コンポーネント（x-input / x-select / x-textarea / x-field）は既存のものを使用

### 実装内容

- 従来のフォーム部分をコンポーネントに置換

### 実装手順

1. 既存の`<label>/<input>/<select>/<textarea>/@error`を削除
2. 各項目を`<x-xxx>`のように対応するコンポーネントに置換

### 確認内容

- 従来どおり入力フォームが表示されること
- `old()`が優先され、未入力時は`$project->xxx`が表示されること
- バリデーションエラー時にエラーメッセージが表示されること
- `aria-invalid/aria-describedby`が正しく付与されていること（アクセシビリティ）
- disabled の見た目（背景色・カーソル）が正しく反映されること
- 日付フィールドが`null`の場合でもエラーにならないこと
- フォーム送信時の挙動が従来と変わらないこと

### 気づき・課題

- コンポーネント化により`edit.blade.php`の記述量が大幅に減り、可読性が向上した
- ラベル・エラー表示・help の UI が統一され、画面間のデザイン差異が解消された
- `disabled`の扱い（`@props`に追加）が理解できた
- `$attributes->class([...])`の「クラス名 → 条件」という Laravel の思想を理解した
- null セーフ演算子（`?->`）により、日付の null 対応が安全に書けるようになった

---

## 機能名：案件履歴新規登録画面のコンポーネント化

### 目的

- 案件履歴新規登録画面で重複して記述していたフォーム要素をコンポーネントとして共通化し、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/interaction-create-form**

### 実装日：2026-04-04 ~ 2026-04-05

### 作成・変更・自動生成されたファイル

- `resources/views/interactions/create.blade.php`（更新）
- `resources/views/components/select.blade.php`（更新）
- `app/Http/Controllers/InteractionController.php`（更新）
  ※ コンポーネント（x-input / x-select / x-textarea / x-field）は既存のものを使用

### 実装内容

- 従来のフォーム部分をコンポーネントに置換

### 実装手順

1. InteractionController@create の変更

- 案件名・顧客名の選択肢を`pluck('title'/'name', 'id')`に変更し、`<x-select>`が扱いやすい 連想配列形式（id => title/name）に整形

2. `create.blade.php`の変更

- 既存の`<label>/<input>/<select>/<textarea>/@error`を削除
- 各項目を`<x-xxx>`のように対応するコンポーネントに置換
- 案件名の空選択肢は`emptyLabel`を利用して「案件未設定（単発対応）」に変更

### 確認内容

- 従来どおり入力フォームが表示されること
- `old()`による入力値の復元が正しく動作すること
- バリデーションエラー時にエラーメッセージが表示されること
- `aria-invalid/aria-describedby`が正しく付与されていること（アクセシビリティ）
- フォーム送信時の挙動が従来と変わらないこと

### 気づき・課題

- コンポーネント化により`create.blade.php`の記述量が大幅に減り、可読性が向上した
- ラベル・エラー表示・help の UI が統一され、画面間のデザイン差異が解消された
- `emptyLabel`の使い方を理解し、柔軟に空選択肢を扱えるようになった

---

## 機能名：案件履歴編集画面のコンポーネント化

### 目的

- 案件履歴編集画面で重複して記述していたフォーム要素をコンポーネントとして共通化し、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/interaction-edit-form**

### 実装日：2026-04-05

### 作成・変更・自動生成されたファイル

- `resources/views/interactions/edit.blade.php`（更新）
  ※ コンポーネント（x-input / x-select / x-textarea / x-field）は既存のものを使用

### 実装内容

- 従来のフォーム部分をコンポーネントに置換

### 実装手順

- 既存の`<label>/<input>/<select>/<textarea>/@error`を削除
- 各項目を`<x-xxx>`のように対応するコンポーネントに置換

### 確認内容

- 従来どおり入力フォームが表示されること
- `old()`が優先され、未入力時は`$interaction->xxx`が表示されること
- バリデーションエラー時にエラーメッセージが表示されること
- `aria-invalid/aria-describedby`が正しく付与されていること（アクセシビリティ）
- disabled の見た目（背景色・カーソル）が正しく反映されること
- フォーム送信時の挙動が従来と変わらないこと

### 気づき・課題

- コンポーネント化により`edit.blade.php`の記述量が大幅に減り、可読性が向上した
- ラベル・エラー表示・help の UI が統一され、画面間のデザイン差異が解消された
- null セーフ演算子は「仕様上 null にならないが、念のための安全装置」として使うことを理解した

---

## 機能名：検索フォームの枠組みコンポーネント化

### 目的

- 顧客・案件・案件履歴の一覧画面で重複して記述していた検索フォームのblade コードをコンポーネントとして共通化し、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/search-form-component**

### 実装日：2026-04-06

### 作成・変更・自動生成されたファイル

- `resources/views/components/search/form.blade.php`（新規）
- `resources/views/customers/index.blade.php`（更新）
- `resources/views/projects/index.blade.php`（更新）
- `resources/views/interactions/index.blade.php`（更新）

### 実装内容

- 検索フォームの枠（form タグ・外枠・タイトル・グリッド・ボタン）のコンポーネントを作成
- 3つの`index.blade.php`から重複コードを削除し、`<x-search.form>`に置換

### 実装手順

#### 1. 検索フォームの枠組みコンポーネントを作成

1. `@props`で`action`と`title`を受け取る
2. `<form>`タグを作成し、`$attributes->merge(['class' => 'mb-6'])`を適用
3. 外枠（border / padding / background）を追加
4. タイトル欄を追加
5. グリッドレイアウトを追加
6. ボタン欄（クリア・検索）を追加
7. クリアボタンのリンク先を`$action`に統一

#### 2. 各`index.blade.php`の検索フォームをコンポーネントに置換

- `customers.index / projects.index / interactions.index`の検索フォーム部分を`<x-search.form>`に置換し、検索項目のみ slot として残すように変更

### 確認内容

- UI が元と同じであること（背景・余白・レイアウト）
- 検索動作が変わっていないこと
- ページネーション・ソートが正常に動作すること
- クリアボタンが正しい index に遷移すること
- 3画面すべてで共通コンポーネントが正常に動作すること

### 気づき・課題

- コンポーネントには「レイアウトコンポーネント」と「入力コンポーネント」の2種類がある
- 今回の`form.blade.php`は「レイアウトコンポーネント」であり、シンプルな構造が適している
- 入力項目（input/select）は別ブランチでコンポーネント化の予定

---

## 機能名：検索フォームボタンのコンポーネント化

### 目的

- 顧客・案件・案件履歴の一覧画面で重複して記述していた検索フォーム内のボタン（検索・クリア）部分を専用コンポーネントとして共通化し、責務分離・可読性・保守性・再利用性を向上させるため
- 検索フォーム枠組みコンポーネント（`<x-search.form>`）からボタンの責務を切り離し、UI パターンごとの役割を明確にするため
- 既存の`<x-button.primary>`/`<x-button.secondary>`を内部で利用することで、ボタンデザインの統一性を確保し、後の UI 変更を容易にするため

### ブランチ名：**feature/search-buttons-component**

### 実装日：2026-04-07

### 作成・変更・自動生成されたファイル

- `resources/views/components/search/button/clear.blade.php`（新規）
- `resources/views/components/search/button/submit.blade.php`（新規）
- `resources/views/components/search/form.blade.php`（更新）

### 実装内容

- 検索フォーム専用ボタン（クリア・検索）のコンポーネントを作成
- `<x-search.form>`内のボタン部分を`<x-search.button.clear>`/`<x-search.button.submit>`に置換

### 実装手順

1. クリアボタンコンポーネントを作成

- `@props(['href'])`を定義
- `<x-button.secondary>`を呼び出し、`:href="$href"`を適用

2. 検索ボタンコンポーネントを作成

- `<x-button.primary type="submit">検索</x-button.primary>`を定義

3. `<x-search.form>`のボタン部分を置換

- 既存の`<a>`/`<button>`を削除し、専用コンポーネントに置換

### 確認内容

- 検索ボタンを押すと検索できること
- クリアボタンを押すと検索条件がリセットされること
- ボタンの見た目が崩れていないこと
- ダークモードでも問題ないこと

### 気づき・課題

- 専用コンポーネントを作成することで、UI の統一性と保守性が向上することを理解できた
- Blade コンポーネントの呼び出し構造（index → form → clear/submit → primary/secondary）を理解できた
- 用途が固定されたコンポーネントは props を減らし、責務を明確にするのが良い設計であることを理解できた

---

## 機能名：検索フォーム入力項目のコンポーネント化

### 目的

- 顧客・案件・案件履歴の検索フォームで重複して記述されている input / select / date の HTML をコンポーネント化し、責務分離・可読性・保守性・再利用性を向上させるため
- `<x-search.form>`内の検索項目部分をスリム化し、検索フォームの構造と項目の責務を分離するため
- Tailwind のクラスを統一し、UI の一貫性を高めるため
- 今後の検索項目追加・変更を 1 箇所で完結できるようにするため

### ブランチ名：**feature/search-input-components**

### 実装日：2026-04-07 ~ 2026-04-09

### 作成・変更・自動生成されたファイル

- `resources/views/components/search/input.blade.php`（新規）
- `resources/views/components/search/select.blade.php`（新規）
- `resources/views/components/search/date.blade.php`（新規）
- `resources/views/components/search/range.blade.php`（新規）
- `customers/index.blade.php`（変更）
- `projects/index.blade.php`（変更）
- `interactions/index.blade.php`（変更）
- `app/Http/Controllers/CustomerController.php`（変更）
- `app/Http/Controllers/ProjectController.php`（変更）
- `app/Http/Controllers/InteractionController.php`（変更）

### 実装内容

- 検索フォーム専用入力項目（ input / select / date / range ）コンポーネントの作成
- 顧客・案件・案件履歴の`index.blade.php`の検索フォームをコンポーネントに置換

### 実装手順

1. input コンポーネントの作成

- 単一行テキスト入力（キーワードなど）を共通化
- Tailwind のクラスを統一
- placeholder / value / name を props 化

2. select コンポーネントの作成

- ステータス・担当者などのセレクトボックスを共通化
- options を配列で受け取り、動的に生成

3. date コンポーネントの作成

- 日付範囲（from/to）を共通化
- `name="created_at"` → `created_at_from` / `created_at_to` を自動生成
- request() の値を保持できるように props 化

4. range コンポーネントの作成（数値範囲専用）

- 金額などの数値範囲（from/to）を共通化
- `name="amount"` → `amount_from` / `amount_to` を自動生成
- `type="number"` / `min="0"` を内部で固定（数値範囲専用のため）

5. 各`index.blade.php`の検索フォームをコンポーネントに置換

- customers / projects / interactions の検索フォームをすべてコンポーネント化

### 確認内容

- 検索値が正しく保持されること
- request() の値が正しく反映されること
- 検索結果が正しく絞り込まれること
- UI が崩れていないこと
- ダークモード対応が維持されていること

### 気づき・課題

- create/edit 用のコンポーネントと検索フォーム用のコンポーネントは別にすることを理解した
  → 検索フォームは「空文字を許容」「id 不要」「value の扱いが特殊」など仕様が異なるため
- 検索フォームでは input の value は null ではなく空文字にすることを理解した
  → null だと HTML の value="" と一致せず、値保持が崩れるため
- 検索フォームでは id 属性は不要であることを理解した
  → label の for を使わないため、id を省略しても問題ない
- name の命名規則（xxx_from / xxx_to）を統一することで、モデル側の scope と連携しやすくなる
- range コンポーネントは数値範囲専用として作る方が実務的に扱いやすい

---

## 機能名：sortable テーブルヘッダーのコンポーネント化

### 目的

- 顧客・案件・案件履歴のテーブルヘッダーのソート機能を Blade コンポーネント化することで、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/sortable-table-header-component**

### 実装日：2026-04-10 ~ 2026-04-11

### 作成・変更・自動生成されたファイル

- `resources/views/components/table/sortable-header.blade.php`（新規）
- `customers/index.blade.php`（更新）
- `projects/index.blade.php`（更新）
- `interactions/index.blade.php`（更新）

### 実装内容

- ソート可能なテーブルヘッダーのコンポーネントを作成
- customers / projects / interactions の各`index.blade.php`のソート対象カラムをすべて置換

### 実装手順

1. sortable-header コンポーネントの作成

- `@props(['label', 'column'])`を定義
- `@php`ブロックで以下を計算
    - 現在の sort / direction
    - 次の direction
    - 現在のルート名
    - 検索条件を保持したままのソート URL
- ソートリンク生成ロジックを実装
- 昇順/降順アイコンの表示ロジックを実装

2. 各`index.blade.php`のソート対象カラムをコンポーネントに置換

- customers / projects / interactions のすべてのソート対象カラムを`<x-table.sortable-header>`に置換

### 確認内容

- ソート方向が正しく切り替わる
- 検索条件と共存できる（検索後にソートしても条件が保持される）
- ページネーションと干渉しない

### 気づき・課題

- props が少なく、ロジックが Blade 内で完結する場合は Blade-only コンポーネントで実装する
- `request()->route()->getName()`の理解が深まった
  → 現在のルート名を自動取得することで、どの画面でも再利用可能になる
- JOIN 時の曖昧カラム（ambiguous column）問題を理解した
  → JOIN 先にも同名カラムがある場合は「テーブル名.カラム名」を必ず指定する
- Blade コンポーネント化により、各`index.blade.php`の重複コードが大幅に削減された

---

## 機能名：顧客詳細ページの強化（案件一覧・対応履歴一覧の表示）

### 目的

- 顧客ごとに案件状況や対応履歴を一覧で把握できるようにし、顧客の状態を総合的に判断できる画面にするため

### ブランチ名：**feature/customer-detail-relations**

### 実装日：2026-04-12 ~ 2026-04-13

### 作成・変更・自動生成されたファイル

- `app/Http/Controllers/CustomerController.php`（更新）
- `resources/views/customers/show.blade.php`（更新）

### 実装内容

- 顧客詳細ページに案件一覧テーブルと対応履歴一覧テーブルを追加
- 案件・対応履歴ともに新しい順に並び替え
- 関係案件・案件名をリンク化
- テーブルの UI を統一（Tailwind）
- null 値に対する表示（未設定）を統一
- ダークモード対応の調整

### 実装手順

1. `CustomerController@show`の拡張

- `load()`による N+1 防止
- 案件一覧・対応履歴一覧をクエリビルダで並び替えて取得

2. `customers/show.Blade.php`に案件一覧テーブルを追加

- セクションタイトルの追加
- 簡易リスト → テーブル形式へ変更
- カラム追加（案件名・ステータス・金額・期間・担当者・作成日）
- 案件名をリンク化

3. `customers/show.Blade.php`に対応履歴一覧テーブルを追加

- セクションタイトルの追加
- 簡易リスト → テーブル形式へ変更
- カラム追加（対応日時・種別・内容・担当者・関係案件）
- 関係案件をリンク化

### 確認内容

- 案件一覧・対応履歴一覧が正しく表示されること
- 並び順が新しい順になっていること
- null 値が「未設定」として表示されること
- ダークモードでも UI が崩れないこと
- リンクが正しく遷移すること

### 気づき・課題

- `load()`と`with()`の違いを理解した
  → `with()`は取得前、`load()`は取得後にリレーションを読み込む
- リレーションメソッドとリレーション結果の違いを理解した
  → `interactions()`はクエリビルダ、`interactions`はコレクション
- `isEmpty()`を使ったコレクション判定を理解した
- モデル定数（STATUS/TYPES）を使ったラベル管理を再確認
  → DB にはコード値、表示は定数配列というパターンを再理解
- エルビス演算子（`?:`）と`optional()`を使った null 安全な表示を理解した
- Blade の`{{ }}`と`:`の役割を整理できた
  → `{{ }}`は HTML 内の表示、`:`はコンポーネント内で記述する値の橋渡し
- `orderByDesc()`を使った並び替えを実装できた
- 今後は「対応履歴の全文ツールチップ」、「顧客詳細からの対応履歴追加ボタン」を要検討
- コンポーネント化は別ブランチで実装予定

---

## 機能名：顧客詳細ページの案件一覧・対応履歴一覧のコンポーネント化

### 目的

- 顧客詳細画面の案件一覧・対応履歴一覧をコンポーネント化し、責務分離・可読性・保守性・再利用性を向上させるため

### ブランチ名：**refactor/customer-detail-components**

### 実装日：2026-04-14 ~ 2026-04-15

### 作成・変更・自動生成されたファイル

- `resources/views/components/customer/project-list.blade.php`（新規）
- `resources/views/components/customer/interaction-list.blade.php`（新規）
- `resources/views/customers/show.blade.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）

### 実装内容

- 案件一覧と対応履歴一覧のコンポーネント作成
- `customers/show.blade.php`の案件一覧・対応履歴一覧をコンポーネントに置換
- `CustomerController@show`の最適化

### 実装手順

1. 案件一覧コンポーネントの作成

- セクションタイトルを追加（件数表示含む）
- 空データ時のメッセージを追加
- `<table>` の `<thead>`部分を追加
- `<table>` の`<tbody>`（`@foreach`）部分を追加
- Tailwind CSS による行のスタイル（odd/even）もコンポーネント側へ移動

2. 対応履歴一覧コンポーネントの作成

- セクションタイトルを追加（件数表示含む）
- 空データ時のメッセージを追加
- `<table>` の `<thead>`部分を追加
- `<table>` の`<tbody>`（`@foreach`）部分を追加
- 関連案件リンクや担当者名の表示もコンポーネント側へ移動

3. `customers/show.blade.php`の案件一覧・対応履歴一覧をコンポーネントに置換

- 案件一覧テーブルを`<x-customer.project-list :project="$project" />`に置換
- 対応履歴一覧テーブルを`<x-customer.interaction-list :interaction="$interaction" />`に置換

4. `CustomerController@show`の最適化

- `load()`の中で並び替え（orderBy）も実行し、projects / interactions の二重取得を解消
- `with()`を追加し、assignedUser / project の eager load により N+1 を解消
- Blade 側で追加クエリが発生しないように最適化

### 確認内容

- 案件一覧・対応履歴一覧が正しく表示されること
- 並び替えが正しく適用されていること
- 空データ時にメッセージが表示されること
- show.blade.php がコンポーネント呼び出しのみでシンプルになっていること

### 気づき・課題

- `:projects="$projects"`の意味を理解できた
  → `:`は「PHP の式として評価する」
  → `$projects`はコントローラから渡された変数
  → コンポーネント側では`$projects`として受け取れる
- `$customer->load()`と`$customer->projects()->get()`はどちらも SELECT を実行することを理解できた
  → 二重取得を避けるために`load()`に統一した
- `with()`を使うことで関連モデルをまとめて取得でき、N+1 を防げることを理解した
  → ループ内で`$interaction->assignedUser`を参照しても追加クエリが発生しない
- Blade コンポーネント化により`show.blade.php`の責務が「ページ構造」だけになり、可読性が大幅に向上した

---

## 機能名：権限管理（Policy）

### 目的

- 認可ロジックを Policy に集約し、保守性の高いアクセス制御を実現するため
- 顧客・案件・対応履歴を 担当者以外が編集・削除できないようにし、誤操作・不正操作を防ぐため
- UI とバックエンドの両方で認可を行い、データの安全性と信頼性を高めるため

### ブランチ名：**feature/policy**

### 実装日：2026-04-15 ~ 2026-04-16

### 作成・変更・自動生成されたファイル

- `app/Policies/CustomerPolicy.php`（新規）
- `app/Policies/ProjectPolicy.php`（新規）
- `app/Policies/InteractionPolicy.php`（新規）
- `app/Providers/AuthServiceProvider.php`（新規）
- `bootstrap/providers.php`（新規・自動生成）
- `app/Http/Controllers/CustomerController.php`（更新）
- `app/Http/Controllers/ProjectController.php`（更新）
- `app/Http/Controllers/InteractionController.php`（更新）
- `resources/views/customers/show.blade.php`（更新）
- `resources/views/projects/show.blade.php`（更新）
- `resources/views/interactions/show.blade.php`（更新）

### 実装内容

- Customer / Project / Interaction の各 Policy を作成し、viewAny / view / create は許可、update / delete は担当者のみ許可、restore/forceDelete は禁止 に統一
- AuthServiceProvider を作成し、モデルと Policy を紐づけ
- Controller に AuthorizesRequests を追加
- 各 Controller に authorizeResource() を追加し、Policy を自動適用
- 各詳細画面の編集・削除ボタンに @can を追加し、担当者以外には UI 上もボタンが表示されないように制御

### 実装手順

1. Policy の実装

- Policy ファイルの作成

```sh
php artisan make:policy CustomerPolicy --model=Customer
php artisan make:policy ProjectPolicy --model=Project
php artisan make:policy InteractionPolicy --model=Interaction
```

2. AuthServiceProvider の作成と設定

- Laravel12 では AuthServiceProvider が自動生成されないため、手動で作成

```sh
php artisan make:provider AuthServiceProvider
```

- `$policies`にモデルとPolicy の紐づけ

3. Controller に認可機能を追加

- Laravel12 の Controller は最小構成のため、`AuthorizesRequests`を自分で追加する必要がある
- `use Illuminate\Foundation\Auth\Access\AuthorizesRequests;`を追加

4. 各コントローラに authorizeResource を追加

- index/show/edit/update/destroy などのアクションに対応する Policy メソッドが自動で適用される
- CustomerController のコンストラクタに`$this->authorizeResource(Customer::class, 'customer')`を追加
- ProjectController のコンストラクタに`$this->authorizeResource(Project::class, 'project')`を追加
- InteractionController のコンストラクタに`$this->authorizeResource(Interaction::class, 'interaction')`を追加

5. Policy の中身を実装

- CustomerPolicy の`viewAny()` / `view()` / `create()`を`true`に、`update()` / `delete()`に`return $user->id === $customer->assigned_user_id;`を追加
- ProjectPolicy の`viewAny()` / `view()` / `create()`を`true`に、`update()` / `delete()`に`return $user->id === $project->assigned_user_id;`を追加
- InteractionPolicy の`viewAny()` / `view()` / `create()`を`true`に、`update()` / `delete()`に`return $user->id === $interaction->assigned_user_id;`を追加

6. Blade に @can を追加（UI の制御）

- 各詳細画面（`show.blade.php`）の編集・削除ボタンにPolicy に基づく表示制御を追加
- UI とバックエンドの認可が一致することで、誤操作と不正アクセスの両方を防止

### 確認内容

- 一覧・詳細は全ユーザーが閲覧可能であること
- 担当者のみ編集・削除ボタンが表示されること
- URL を直接入力しても、担当者以外は 403 になること
- UI とバックエンドの認可が一致している

### 気づき・課題

- ServiceProvider の役割
  アプリ起動時に読み込まれる設定を管理するクラスであることを理解した
- Laravel12 の仕様
  Policy の自動検出が有効
  AuthServiceProvider がデフォルトで存在しない
  authorizeResource() を使う場合は AuthServiceProvider が必要
  Controller に AuthorizesRequests を追加する必要がある
- ::class の理解
  クラスの完全修飾名（FQCN）を文字列として返す仕組み
- authorizeResource() の理解
  コントローラの各アクションに Policy を自動で紐づける便利なメソッド
- Policy の役割
  各アクションに対して true / false / 条件式 を返すことで認可を制御できる
- @can の理解
  Blade 上で Policy の結果に応じて UI を制御できる

---

## 機能名：顧客一覧画面の CSV エクスポート

### 目的

- 担当者が Excel などで顧客データを分析・共有しやすくするため
- 検索・ソート条件を反映した CSV を出力し、ユーザー体験を向上させるため

### ブランチ名：**feature/customer-csv-export**

### 実装日：2026-04-17 ~ 2026-04-19

### 作成・変更・自動生成されたファイル

- `routes/web.php`（更新）
- `app/Http/Controllers/CustomerController.php`（更新）
- `resources/views/customers/index.blade.php`（更新）
- `app/Traits/Sortable.php`（改善）
- `app/Models/Customer.php`（改善）

### 実装内容

- CSV エクスポート用のルートを追加
- CustomerController に export() メソッドを実装
    - 検索条件（keyword / status / assigned_user / created_at_range）を反映
    - ソート条件（sort / direction）を反映
    - Excel で文字化けしないよう BOM を付与
- 顧客一覧画面に「CSV エクスポート」ボタンを追加

### 実装手順

1. `routes/web.php`にルートの追加

- `routes/web.php`に`Route::get('customers/export', [CustomerController::class, export])->name('customers.export');`を追加
  ※`Route::resource('customers', ...)`より前に記述する必要がある（後ろに書くと`/customers/export`が`/customers/{customer}`と解釈され 404 になる）

2. Controller に export() メソッドを追加

- 空のメソッドを作成し、固定文字列の CSV を返して動作確認
- 検索条件を反映したクエリを取得
- Sortable トレイトを利用してソートを統一
- CSV 文字列を生成
- BOM を付与して Excel 文字化け対策
- `Content-Type`と`Content-Disposition`を設定してレスポンスを返す

3. 顧客一覧画面に「CSV エクスポート」ボタンを追加

- Blade 側で HTML エスケープを避けるために`<x-button.secondary :href="route( ... ))">`と記述

### 確認内容

- 検索条件が正しく反映されていること
- ソート条件が正しく反映されていること
- Excel で開けること
- 日本語が文字化けしないこと
- 一覧画面と CSV の並びが一致すること

### 気づき・課題

- ルーティングの理解が深まった
  → `middleware(['auth', 'verified'])`はログイン必須＋メール認証必須
  → `require **DIR**.'/auth.php';`は認証ルートの読み込み
  → `Route::resource()`の自動生成ルートの仕組みを理解
  → ルートの優先順位が重要（export を resource より前に書く必要がある）
- Blade の HTML エスケープの罠を理解した
  → `href="{{ ... }}"`は`&`が`&amp;`にエスケープされる
  → その結果、`direction=asc`が正しく渡らず 常に desc になるバグが発生
  → `:href="..."`を使うことでエスケープを回避できることを学んだ
- Sortable トレイトの改善
  → Laravel のスコープは 第2引数を取らない形が正しい
  → `$request`を直接受け取る形は非推奨
  → `request()`を使う形に修正
  → ソート処理を一覧画面と CSV で統一できた
- スコープの return の重要性
  → `scopeAssignedUser()`の return 漏れを修正
  → スコープチェーンが途切れるとソートが実行されない可能性がある
  → 全スコープで`$query`を返すよう統一した
- CSV の品質向上
  → カンマを含む値は`" "`で囲む必要がある
  → BOM を付けることで Excel の文字化けを防げる
  → CSV 出力は「ただの文字列」ではなく「データの持ち出し機能」であることを理解

---

## 機能名：案件一覧画面の CSV エクスポート

### 目的

- 担当者が Excel などで顧客データを分析・共有しやすくするため
- 検索・ソート条件を反映した CSV を出力し、ユーザー体験を向上させるため

### ブランチ名：**feature/project-csv-export**

### 実装日：2026-04-20

### 作成・変更・自動生成されたファイル

- `routes/web.php`（更新）
- `app/Http/Controllers/ProjectController.php`（更新）
- `resources/views/projects/index.blade.php`（更新）

### 実装内容

- CSV エクスポート用のルートを追加
    - `/projects/export`を GET で追加
    - `projects.export`という名前付きルートを設定
    - `Route::resource('projects')`より前に記述（後ろに書くと`/projects/{project}`にマッチして 404 になるため）
- CustomerController に export() メソッドを実装
    - 検索条件（keyword / customer_id / status / assigned_user_id / amount / period_from / period_to / created_at）を反映
    - ソート条件（sort / direction）を反映
    - Eloquent の結果をループして CSV 文字列を生成
    - Excel 文字化け対策として UTF-8 BOM（`\xEF\xBB\xBF`）を付与
    - `response()`を使って CSV をダウンロードさせるレスポンスを返却
- 顧客一覧画面に「CSV エクスポート」ボタンを追加
    - Blade コンポーネント`<x-button.secondary>`を使用
    - `route('projects.export', request()->query())`を使い、現在の検索・ソート条件をそのまま引き継いだ URL を生成
    - HTML エスケープを避けるため`:href="..."`を使用

### 実装手順

1. `routes/web.php`にルートの追加

- `/projects/export`を GET で追加し、名前付きルート`projects.export`を設定

2. Controller に export() メソッドを追加

- 最初は固定文字列の CSV を返す
- 次に 1 件の実データを返す
- 次に複数件のデータを返す
- 検索・ソート条件を反映
- 最後に BOM を付与して Excel 文字化け対策を実装

3. 顧客一覧画面に「CSV エクスポート」ボタンを追加

- 現在の検索条件を引き継ぐため`request()->query()`を使用
- `<x-button.secondary>`で UI に統一感を持たせる

### 確認内容

- 検索条件が CSV に正しく反映されること
- ソート条件が CSV に正しく反映されること
- Excel で開いても文字化けしないこと
- CSV の列順が一覧画面と一致していること
- CSV ダウンロードが正常に行えること

### 気づき・課題

- Eloquent モデルの実データは`attributes`に格納されており、その他にも多くのメタ情報が含まれることを理解した
- `\xEF\xBB\xBF`の`\x`は「16進数のバイト値として扱う」という意味であり、UTF-8 BOM の 3 バイトを表現している
- 今後の改善ポイント
    - N+1 問題の解消（with() の追加）
    - ファイル名に日時を付与してユーザーが管理しやすくする
    - CSV のエスケープ処理（カンマ・改行対応）
    - 大量データ対応（ストリーム出力）

---

## 機能名：顧客ドメインテスト

### 目的

- 顧客ドメイン（顧客・案件・対応履歴・担当者の関係を含む）の既存機能を自動テストで保証し、品質を向上させる
- リファクタリングや機能追加時に、既存機能が壊れていないことを即座に確認できる基盤を作る
- 開発者が安心してコードを変更できる環境を整える

### ブランチ名：**test/customer-domain-tests**

### 実装日：2026-04-21 ~ 2026-04-29

### 作成・変更・自動生成されたファイル

- `tests/CreatesUser.php`（新規）
- `tests/TestCase.php`（新規）
- `tests/Feature/Customer/CustomerIndexTest.php`（新規）
- `tests/Feature/Customer/CustomerCreateTest.php`（新規）
- `tests/Feature/Customer/CustomerEditTest.php`（新規）
- `tests/Feature/Customer/CustomerShowTest.php`（新規）
- `tests/Feature/Customer/CustomerDeleteTest.php`（新規）
- `tests/Unit/Requests/CustomerStoreRequestTest.php`（新規）
- `tests/Unit/Requests/CustomerUpdateRequestTest.php`（新規）
- `tests/Unit/Policies/CustomerPolicyTest.php`（新規）
- `tests/Feature/Customer/CustomerSearchTest.php`（新規）
- `tests/Feature/Customer/CustomerSortTest.php`（新規）
- `tests/Feature/Customer/CustomerRelationTest.php`（新規）

### 実装内容

- ログインヘルパー Trait の作成
    - TestCase に Trait を読み込み
- 顧客 CRUD の Feature テスト
    - 一覧 / 作成 / 編集 / 詳細 / 論理削除
    - 認可（未ログイン / Policy）
    - バリデーション
    - DB 反映の確認
- FormRequest バリデーションの Unit テスト
    - 必須項目
    - 形式チェック（email / phone / postal_code）
    - Enum の valid / invalid
- Policy の Unit テスト
    - viewAny / view / create / update / delete / restore / forceDelete
- 検索機能テスト
    - 各項目の部分一致・完全一致
    - 絞り込み
    - 複数条件
    - 検索なし時の全件表示
- ソート機能テスト
    - name / email / company_name / created_at
    - 昇順・降順
    - デフォルトソート
- リレーションテスト
    - belongsTo / hasMany
    - 外部キー制約（restrict / nullOnDelete）

### 実装手順

#### 1. テスト環境の準備

1. `phpunit.xml`の DB 設定確認

- 下記の設定を確認

    ```sh
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    ```

2. ログインヘルパー Trait の作成

- `tests/CreatesUser.php`を作成
- `tests/TestCase.php`に Trait を追加

#### 2. CRUD 機能テスト

1. `CustomerIndexTest.php`を作成

- 一覧画面の閲覧テストを追加
- Customer の一覧表示のテストを追加
- 未ログインユーザーのアクセス制限（認可）テスト（index）を追加

2. `CustomerCreateTest.php`を作成

- 顧客作成画面の表示テストの追加
- customers テーブルへの新規登録テストを追加
- 入力必須項目のバリデーションエラーのテストを追加
- 未ログインユーザーのアクセス制限（認可）テスト（create / store）を追加

3. `CustomerEditTest.php`を作成

- 顧客編集画面の表示テストの追加
- customers テーブルの更新処理テストを追加
- 入力必須項目のバリデーションエラーのテストを追加
- 未ログインユーザーのアクセス制限（認可）テスト（edit / update）を追加
- ポリシー（403）テスト（edit / update）を追加

4. `CustomerShowTest.php`を作成

- 顧客詳細画面の表示テストの追加
- 未ログインユーザーのアクセス制限（認可）テストを追加

5. `CustomerDeleteTest.php`を作成

- customers テーブルの論理削除処理テストを追加
- 未ログインユーザーのアクセス制限（認可）テストを追加
- ポリシー（403）テストを追加

#### 3. FormRequest バリデーション単体テスト

1. `CustomerStoreRequestTest.php`を作成

- 必須項目（`name`/`status`/`rank`）テストを追加
- `email`の形式テスト（valid / invalid）を追加
- `phone`の形式テスト（valid / invalid）を追加
- `postal_code`の形式テスト（valid / invalid）を追加
- `status`/`rank`の Enum テスト（valid / invalid）を追加

2. `CustomerUpdateRequestTest.php`を作成

- 必須項目（`name`/`status`/`rank`）テストを追加
- `email`の形式テスト（valid / invalid）を追加
- `phone`の形式テスト（valid / invalid）を追加
- `postal_code`の形式テスト（valid / invalid）を追加
- `status`/`rank`の Enum テスト（valid / invalid）を追加

#### 4. Policy 単体テスト

- `viewAny`（一覧閲覧）テストを追加
- `view`（個別閲覧）テストを追加
- `create`（新規作成）テストを追加
- `update`（更新）テストを追加
- `delete`（削除）テストを追加
- `restore`（復元）テストを追加
- `forceDelete`（完全削除）テストを追加

#### 5. 検索機能テスト

- `name`の部分一致検索テストを追加
- `email`の部分一致 / 完全一致検索テストを追加
- `phone`の部分一致検索テストを追加
- `company_name`の部分一致検索テストを追加
- `status`の絞り込み検索テストを追加
- `assigned_user_id`の絞り込み検索テストを追加
- `created_at`の範囲検索テストを追加
- 複数条件の AND 検索テストを追加
- 検索なしの場合の全件表示テストを追加

#### 6. ソート機能テスト

- `name`の昇順・降順ソートテストを追加
- `email`の昇順・降順ソートテストを追加
- `company_name`の昇順・降順ソートテストを追加
- `created_at`の昇順・降順ソートテストを追加
- デフォルトソート（sort パラメータなし）テストを追加

#### 7. リレーション機能テスト

- `Customer` → `User` の belongsTo テストを追加
- `Customer` → `Projects` の hasMany テストを追加
- `Customer` → `Interactions` の hasMany テストを追加
- `Project` → `Customer` の belongsTo テストを追加
- `Interaction` → `Customer` の belongsTo テストを追加
- `User` → `Customer`s の hasMany テストを追加
- `Customer`削除時の外部キー制約（`Project` / `restrict`）のテストを追加
- `Customer`削除時の外部キー制約（`Interaction` / `restrict`）のテストを追加
- `User`削除時の外部キー制約（`Customer` / `restrict`）のテストを追加
- `User`削除時の外部キー制約（`Project` / `restrict`）のテストを追加
- `User`削除時の外部キー制約（`Interaction` / `restrict`）のテストを追加
- `Project`削除時の外部キー制約（`Interaction` / `nullOnDelete`）のテストを追加

### 確認内容

- 全テストが PASS したこと

### 気づき・課題

- 下記のことを理解した
  → 実務では、意図しない挙動を早期に発見するために、機能を実装したらすぐテストを記述する
  → `php artisan test`は「テストを実行するコマンド」
  → `TestCase.php`は「全テストの親クラス」
  → `factory()->count()->create()`が柔軟で標準的な記述
  → `actingAs()`は「ログイン状態を作るメソッド」
  → `it()`は「Pest が提供しているテストを書くためのメソッド」
  → `get()`は「GET リクエストを送信するメソッド」
  → `post()`は「POST リクエストを送信するメソッド」
  → `patch()`は「PATCH リクエストを送信するメソッド」
  → `delete()`は「DELETE リクエストを送信するメソッド」
  → `assertOk()`は「HTTP 200（成功）を確認するメソッド」
  → `assertSee()`は「レスポンスの HTML に引数の文字列が含まれていることを確認するメソッド」
  → `assertDontSee()`は「レスポンスの HTML に引数の文字列が含まれていないことを確認するメソッド」
  → `assertRedirect()`は「未ログイン時はログイン画面に遷移させるメソッド」
  → `assertDatabaseHas()`は「DB にデータが保存されていることを確認するメソッド」
  → `assertSoftDeleted()`は「DB からデータがソフトデリートされていることを確認するメソッド」
  → `assertStatus()`は「HTTP レスポンスのステータスコードを確認するメソッド」
  → `assertSessionHasErrors()`は「セッションにバリデーションエラーが存在することを確認するメソッド」
  → `uses()`は「引数のクラスなどを使用するメソッド」
  → `Validator::make()`は「バリデーションを実行するメソッド」
  → `validator()->fails()`は「入力がルールに違反している確認するメソッド」
  → `expect($value)->toBeTrue() / toBeFalse()`は「$value が true / false であることを確認するメソッド」
  → `expect($value1)->toBe($value2)`は「$value1 が $value2 と完全一致であることを確認するメソッド」
  → `with()`は「同じテストで複数のデータを渡すメソッド」（データプロバイダ機能）
  → 「データ駆動テスト」は考え方や手法、「データプロバイダ機能」はデータ駆動テストを実現する仕組みや機能
  → Unit テストでは、TestCase のメソッド（作成した`loginUser()`など）は使えない
  → Unit テストでは、DB を使う前提になっていないので、`uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);`を追加する
  → email の検索テストでは、一意性を持つフィールドになることが多いので、完全一致と部分一致をテストする
  → `<select>`の検索テストでは、レスポンス HTML に必ず`<option value="〇〇">`が含まれるため、検索対象の値（status, rank など）を`assertSee()`/`assertDontSee()`で判定してはいけない
  → `assertSeeInOrder()`は「文字列の出現順をチェックするメソッド」
  → hasMany のリレーションテストでは、`count()`で件数を確認する
  → 削除時の外部キー制約のテストでは、Eloquentは使えないので、`DB::table()->delete()`を使う
  → `toThrow()`は「例外を投げることを確認するメソッド」
  → `toBeNull()`は「null であることを確認するメソッド」

- 下記のことを復習できた
  → マイグレーションの`constrained()`は「別テーブルの id と紐づく外部キーであることを宣言するメソッド」
  → マイグレーションの`restrictOnDelete()`は「子がいる親は削除を禁止するメソッド」
  → マイグレーションの`cascadeOnDelete()`は「親を削除したら、子も一緒に削除するメソッド」
  → マイグレーションの`nullOnDelete()`は「親を削除したら、子の親IDを空にするメソッド」

---

## 機能名：案件ドメインテスト

### 目的

- 案件ドメインの既存機能を自動テストで保証し、品質を向上させるため
- リファクタリングや機能追加時に、既存機能が壊れていないことを即座に確認できる基盤を作るため
- 開発者が安心してコードを変更できる環境を整えるため

### ブランチ名：**test/project-domain-tests**

### 実装日：2026-04-30 ~ 2026-05-7

### 作成・変更・自動生成されたファイル

- `tests/Feature/Project/ProjectIndexTest.php`（新規）
- `tests/Feature/Project/ProjectCreateTest.php`（新規）
- `tests/Feature//ProjectShowTest.php`（新規）
- `tests/Feature/Project/ProjectEditTest.php`（新規）
- `tests/Feature/Project/ProjectDeleteTest.php`（新規）
- `tests/Unit/Requests/ProjectStoreRequestTest.php`（新規）
- `tests/Unit/Requests/ProjectUpdateRequestTest.php`（新規）
- `tests/Unit/Policies/ProjectPolicyTest.php`（新規）
- `tests/Feature/Project/ProjectSearchTest.php`（新規）
- `tests/Feature/Project/ProjectSortTest.php`（新規）

### 実装内容

- 案件 CRUD の機能テスト
    - 一覧 / 作成 / 編集 / 詳細 / 論理削除
    - 認可（未ログイン / Policy）
    - バリデーション
    - DB 反映の確認
- FormRequest バリデーションの単体テスト
    - 必須項目（`title`/`customer_id`/`status`）
    - 形式チェック（`amount`/`start_date`/`end_date`）
    - `end_date`の`after_or_equal`の valid / invalid
    - Enum の valid / invalid
    - `customer_id`の exists
- Policy の単体テスト
    - `viewAny`/`view`/`create`/`update`/`delete`/`restore`/`forceDelete`
    - 権限あり / なし
- 検索機能テスト
    - `title`の部分一致
    - 絞り込み（`customer_id`/`status`/`assigned_user_id`）
    - 範囲（`amount`/`start_date`/`end_date`/`created_at`）
    - 範囲の逆転（from > to）
    - 複数条件 AND 検索
    - 検索条件なし時の全件表示
- ソート機能テスト
    - `title`/`customer_kana`/`amount`/`created_at`
    - 昇順・降順
    - デフォルトソート（sort パラメータなし → created_at desc）

### 実装手順

#### 1. CRUD 機能テスト

1. `ProjectIndexTest.php`を作成

- 一覧画面表示（ログインユーザーアクセス）テストを追加
- 未ログインユーザーのアクセス制限（認可）テスト（index）を追加

2. `ProjectCreateTest.php`を作成

- 案件作成画面表示（ログインユーザーアクセス）テストの追加
- projects テーブルへの新規登録（ログインユーザーアクセス）テストを追加
- 入力必須項目（`title`/`customer_id`/`status`）のバリデーションエラーテストを追加
- 未ログインユーザーのアクセス制限（認可）テスト（create / store）を追加

3. `ProjectShowTest.php`を作成

- 顧客詳細画面表示（ログインユーザーアクセス）テストの追加
- 未ログインユーザーのアクセス制限（認可）テストを追加

4. `ProjectEditTest.php`を作成

- 案件編集画面表示（ログインユーザーアクセス）テストの追加
- projects テーブルの更新処理（ログインユーザーアクセス）テストを追加
- 入力必須項目（`title`/`status`）バリデーションエラーのテストを追加
- 未ログインユーザーのアクセス制限（認可）テスト（edit / update）を追加
- ポリシー（403）テスト（edit / update）を追加

5. `ProjectDeleteTest.php`を作成

- projects テーブルの論理削除処理（ログインユーザーアクセス）テストを追加
- 未ログインユーザーのアクセス制限（認可）テストを追加
- ポリシー（403）テストを追加

#### 2. FormRequest バリデーション単体テスト

1. `ProjectStoreRequestTest.php`を作成

- 必須項目（`title`/`customer_id`/`status`）テストを追加
- `amount`の形式テスト（valid / invalid）を追加
- `start_date`/`end_date`の形式テスト（valid / invalid）を追加d
- `end_date`の`after_or_equal`テスト（valid / invalid）を追加
- `status`の Enum テスト（valid / invalid）を追加
- `customer_id`の exists テスト（valid / invalid）を追加

2. `ProjectUpdateRequestTest.php`を作成

- 必須項目（`title`/`status`）テストを追加
- `amount`の形式テスト（valid / invalid）を追加
- `start_date`/`end_date`の形式テスト（valid / invalid）を追加
- `end_date`の`after_or_equal`テスト（valid / invalid）を追加
- `status`の Enum テスト（valid / invalid）を追加

#### 3. Policy 単体テスト

- `viewAny`（一覧閲覧）テストを追加
- `view`（個別閲覧）テストを追加
- `create`（新規作成）テストを追加
- `update`（更新）テスト（処理可 / 処理不可）を追加
- `delete`（削除）テスト（処理可 / 処理不可）を追加
- `restore`（復元）テストを追加
- `forceDelete`（完全削除）テストを追加

#### 4. 検索機能テスト

- `title`の部分一致検索テストを追加
- `customer_id`の絞り込み検索テストを追加
- `status`の絞り込み検索テストを追加
- `assigned_user_id`の絞り込み検索テストを追加
- `amount`の範囲検索テスト（順転 / 逆転）を追加
- `start_date`/`end_date`の範囲検索テスト（順転 / 逆転）を追加
- `created_at`の範囲検索テストを追加
- 複数条件の AND 検索テストを追加
- 検索条件なしの場合の全件表示テストを追加

#### 5. ソート機能テスト

- `title`の昇順・降順ソートテストを追加
- `customer_kana`の昇順・降順ソートテストを追加
- `amount`の昇順・降順ソートテストを追加
- `created_at`の昇順・降順ソートテストを追加
- デフォルトソート（sort パラメータなし）テストを追加

### 確認内容

- 全テストが PASS したこと

### 気づき・課題

- `$this->get()`の戻り値は「HTTP レスポンスをテストしやすくしたオブジェクト」であることを理解した
- 仕様により編集できない項目はバリデーション対象にしない（テストも不要）
- Factory の Faker の`realText()`は日本語環境で無限ループになる既知バグがあるため、`sentence()`などに変更する必要がある

---

## 機能名：対応履歴ドメインテスト

### 目的

- 対応履歴ドメインの既存機能を自動テストで保証し、品質を向上させるため
- リファクタリングや機能追加時に、既存機能が壊れていないことを即座に確認できる基盤を作るため
- 開発者が安心してコードを変更できる環境を整えるため

### ブランチ名：**test/interaction-domain-tests**

### 実装日：2026-05-7 ~ 2026-05-11

### 作成・変更・自動生成されたファイル

- `tests/Feature/Interaction/InteractionIndexTest.php`（新規）
- `tests/Feature/Interaction/InteractionCreateTest.php`（新規）
- `tests/Feature/Interaction/InteractionShowTest.php`（新規）
- `tests/Feature/Interaction/InteractionEditTest.php`（新規）
- `tests/Feature/Interaction/InteractionDeleteTest.php`（新規）
- `tests/Unit/Requests/InteractionStoreRequestTest.php`（新規）
- `tests/Unit/Requests/InteractionUpdateRequestTest.php`（新規）
- `tests/Unit/Policies/InteractionPolicyTest.php`（新規）
- `tests/Feature/Interaction/InteractionSearchTest.php`（新規）
- `tests/Feature/Interaction/InteractionSortTest.php`（新規）

### 実装内容

- 対応履歴 CRUD の機能テスト
    - 一覧 / 作成 / 編集 / 詳細 / 論理削除
    - 認可（未ログイン / Policy）
    - バリデーション
    - DB 反映の確認
- FormRequest バリデーションの単体テスト
    - 必須項目（`interacted_at`/`type`/`content`/`customer_id`）
    - 形式チェック（`interacted_at`）
    - `type`の Enum の valid / invalid
    - `project_id`/`customer_id`の exists
- Policy の単体テスト
    - `viewAny`/`view`/`create`/`update`/`delete`/`restore`/`forceDelete`
    - 権限あり / なし
- 検索機能テスト
    - `content_keyword`/`project_keyword`の部分一致
    - 絞り込み（`type`/`customer_id`/`assigned_user_id`）
    - 範囲（`interacted_at`）
    - 範囲の逆転（from > to）
    - 複数条件 AND 検索
    - 検索条件なし時の全件表示
- ソート機能テスト
    - `interacted_at`/`customer_kana`
    - 昇順・降順
    - デフォルトソート（sort パラメータなし → interacted_at desc）

### 実装手順

#### 1. CRUD 機能テスト

1. `InteractionIndexTest.php`を作成

- 一覧画面表示（ログインユーザーアクセス）テストを追加
- 未ログインユーザーのアクセス制限（認可）テスト（index）を追加

2. `InteractionCreateTest.php`を作成

- 対応履歴作成画面表示（ログインユーザーアクセス）テストの追加
- interactions テーブルへの新規登録（ログインユーザーアクセス）テストを追加
- 入力必須項目（`interacted_at`/`type`/`content`/`customer_id`）のバリデーションエラーテストを追加
- 未ログインユーザーのアクセス制限（認可）テスト（create / store）を追加

3. `InteractionShowTest.php`を作成

- 顧客詳細画面表示（ログインユーザーアクセス）テストの追加
- 未ログインユーザーのアクセス制限（認可）テストを追加

4. `InteractionEditTest.php`を作成

- 対応履歴編集画面表示（ログインユーザーアクセス）テストの追加
- interactions テーブルの更新処理（ログインユーザーアクセス）テストを追加
- 入力必須項目（`interacted_at`/`type`/`content`）バリデーションエラーのテストを追加
- 未ログインユーザーのアクセス制限（認可）テスト（edit / update）を追加
- ポリシー（403）テスト（edit / update）を追加

5. `InteractionDeleteTest.php`を作成

- interactions テーブルの論理削除処理（ログインユーザーアクセス）テストを追加
- 未ログインユーザーのアクセス制限（認可）テストを追加
- ポリシー（403）テストを追加

#### 2. FormRequest バリデーション単体テスト

1. `InteractionStoreRequestTest.php`を作成

- 入力必須項目（`interacted_at`/`type`/`content`/`customer_id`）テストを追加
- `interacted_at`の形式テスト（valid / invalid）を追加
- `type`の Enum テスト（valid / invalid）を追加
- `project_id`/`customer_id`の exists テスト（valid / invalid）を追加

2. `InteractionUpdateRequestTest.php`を作成

- 入力必須項目（`interacted_at`/`type`/`content`）テストを追加
- `interacted_at`の形式テスト（valid / invalid）を追加
- `type`の Enum テスト（valid / invalid）を追加

#### 3. Policy 単体テスト

- `viewAny`（一覧閲覧）テストを追加
- `view`（個別閲覧）テストを追加
- `create`（新規作成）テストを追加
- `update`（更新）テスト（処理可 / 処理不可）を追加
- `delete`（削除）テスト（処理可 / 処理不可）を追加
- `restore`（復元）テストを追加
- `forceDelete`（完全削除）テストを追加

#### 4. 検索機能テスト

- `content_keyword`の部分一致検索テストを追加
- `project_keyword`の部分一致検索テストを追加
- `type`の絞り込み検索テストを追加
- `customer_id`の絞り込み検索テストを追加
- `assigned_user_id`の絞り込み検索テストを追加
- `interacted_at`の範囲検索テスト（順転 / 逆転）を追加
- 複数条件の AND 検索テストを追加
- 検索条件なしの場合の全件表示テストを追加

#### 5. ソート機能テスト

- `interacted_at`の昇順・降順ソートテストを追加
- `customer_kana`の昇順・降順ソートテストを追加
- デフォルトソート（sort パラメータなし）テストを追加

### 確認内容

- 全テストが PASS したこと

### 気づき・課題

- `assertSeeText()`は HTML タグを除去したテキストに対してマッチングする
- バリデーションエラー時のリダイレクト先は「元の URL」になるため、store → create に戻るとは限らない
- `factory()->for()`は belongsTo リレーションの外部キーを自動設定する
- `assertForbidden()`は HTTP 403 を確認する
- `$validator->errors()->has()`で「どの項目がエラーか」を確認できる
- データプロバイダの`with()`は連想配列で名前を付けると読みやすい

---

## 機能名：定数の命名規則統一

### 目的

- コードベース全体の命名規則を統一し、一貫性・可読性・保守性を高めるため

### ブランチ名：**refactor/unify-naming-constants**

### 実装日：2026-05-13

### 作成・変更・自動生成されたファイル

- `app/Models/Interaction.php`（変更）
- `resources/views/interactions/index.blade.php`（変更）
- `resources/views/interactions/show.blade.php`（変更）
- `app/Http/Controllers/InteractionController.php`（変更）
- `app/Http/Requests/InteractionStoreRequest.php`（変更）
- `app/Http/Requests/InteractionUpdateRequest.php`（変更）
- `tests/Feature/Interaction/InteractionIndexTest.php`（変更）
- `tests/Feature/Interaction/InteractionEditTest.php`（変更）

### 実装内容

- `Interaction`モデルの定数`TYPE`を`TYPES`に変更
- 上記変更に伴い、定数参照箇所をすべて`TYPES`に統一
    - 一覧画面（index）
    - 詳細画面（show）
    - Controller（検索フォーム用の options）
    - StoreRequest / UpdateRequest（バリデーションの Rule::in）
    - Feature Test（定数参照部分）

### 実装手順

1. モデルの定数名を変更

- `Interaction`モデルの`TYPE`→`TYPES`

2. Blade 側の参照を修正

- `interactions/index.blade.php`
- `interactions/show.blade.php`

3. Controller / FormRequest の参照を修正

- `InteractionController.php`
- `InteractionStoreRequest.php`
- `InteractionUpdateRequest.php`

4. テストコードの参照を修正

- `InteractionIndexTest.php`
- `InteractionEditTest.php`

### 確認内容

- 対応履歴一覧ページ
    - 対応種別が正しく表示される
    - 対応種別で正しく検索できる
- 対応履歴詳細ページ
    - 対応種別が正しく表示される
- 対応履歴作成ページ
    - 対応種別プルダウンが正しく表示される
    - 正しく登録できる
- 対応履歴編集ページ
    - 対応種別プルダウンが正しく表示される
    - 正しく更新できる

### 気づき・課題

- `Interaction`モデルのみ定数が単数形で定義されており、他モデルと命名規則が揃っていなかった
- 定数名の揺れは、Blade・Controller・FormRequest・テストなど複数箇所に影響するため、早期に統一しておくことが重要だと思った

---

## 機能名：Model アクセサの導入

### 目的

- Blade の可読性を向上させるため
- Model に表示ロジックを集約し、責務の一貫性を高めるため
- 定数の変更に強い構造にすることで、保守性を向上させるため

### ブランチ名：**refactor/add-model-accessors**

### 実装日：2026-05-15 ~ 2026-05-16

### 作成・変更・自動生成されたファイル

- `app/Models/Interaction.php`（変更）
- `app/Models/Project.php`（変更）
- `app/Models/Customer.php`（変更）
- `resources/views/interactions/index.blade.php`（変更）
- `resources/views/interactions/show.blade.php`（変更）
- `resources/views/projects/index.blade.php`（変更）
- `resources/views/projects/show.blade.php`（変更）
- `resources/views/customers/index.blade.php`（変更）
- `resources/views/customers/show.blade.php`（変更）
- `resources/views/components/customer/interaction-list.blade.php`（変更）
- `resources/views/components/customer/project-list.blade.php`（変更）
- `tests/Feature/Interaction/InteractionIndexTest.php`（変更）
- `tests/Feature/Interaction/InteractionEditTest.php`（変更）

### 実装内容

- Model にアクセサを追加し、定数 → ラベル変換を Model 側に集約
- Blade から変換ロジックを排除し、表示専用のコードに統一
- コンポーネント内の参照もアクセサに統一
- テストコードもアクセサを利用する形に修正

### 実装手順

1. Model にアクセサを追加

- `Interaction`：`getTypeLabelAttribute()`
- `Project`：`getStatusLabelAttribute()`
- `Customer`：`getStatusLabelAttribute()`/`getRankLabelAttribute()`

2. Blade の参照をアクセサに置換

- interactions（index / show）
- projects（index / show）
- customers（index / show）
- components（interaction-list / project-list）

3. テストコードを修正

- `InteractionIndexTest.php`
- `InteractionEditTest.php`

### 確認内容

- 対応履歴一覧・詳細ページの対応種別が正しく表示されること
- 案件一覧・詳細ページのステータスが正しく表示されること
- 顧客一覧・詳細ページのステータス・ランクが正しく表示されること
- 詳細ページの案件一覧のステータス・対応履歴の対応種別が正しく表示されること
- テストが PASS したこと

### 気づき・課題

- `self`は「そのクラス自身」を指し、`self::定数名`でクラス定数を参照できることを再確認した
- アクセサは`get + 属性名（先頭大文字） + Attribute`という命名規則で定義し、Blade では`$model->属性名`として自然に呼び出せることを理解した
- Blade にロジックを書かず、Model に集約することで保守性が大きく向上することを実感した

---

## 機能名：UI / UX 調整（全 CRUD 画面の統一・改善）

### 目的

- CRUD 全画面の UI を統一し、業務システムとしての一貫性を高めるため
- テーブル・検索フォーム・ボタンなど共通 UI の品質を向上させるため
- 詳細ページの構造を整理し、読みやすさ・操作性を改善させるため
- ログイン後の導線を実務的なフローに合わせて最適化するため
- Blade コンポーネントを整理し、保守性を向上させるため

### ブランチ名：**refactor/ui-ux-polish**

### 実装日：2026-05-18 ~ 2026-05-25

### 作成・変更・自動生成されたファイル

- `routes/web.php`（変更）
- `resources/views/auth/login.blade.php`（変更）
- `resources/views/layouts/navigation.blade.php`（変更）
- `resources/views/customers/*`（変更）
- `resources/views/projects/*`（変更）
- `resources/views/interactions/*`（変更）
- `resources/views/components/*`（変更）

### 実装内容

- 導線の改善（ログイン前後の UX 最適化）
    - `/` → `/login`にリダイレクト
    - `/dashboard` → `customers.index`にリダイレクト
    - ログイン画面に`/register`へのリンクを追加
    - Breeze デフォルトの「Dashboard」を削除し、顧客 / 案件 / 対応履歴 の業務メニューに置き換え
    - `routeIs('customers.*')`などで active 状態を統一
- テーブル UI の統一（全一覧ページ）
    - 行ホバー：`hover:bg-gray-100 dark:hover:bg-gray-600`
    - odd/even：`odd:bg-white even:bg-gray-50`（dark mode 対応）
    - border：`border-gray-200 dark:border-gray-600`
    - th/td：`px-4 py-2`に統一
    - thead 背景：`bg-gray-100 dark:bg-gray-700`
    - テーブル幅：`min-w-full`
    - カード外枠：`border`を追加
    - ソートヘッダー（x-table.sortable-header）の UI を統一
- 検索フォーム（x-search.）の統一
    - カード UI：`border / rounded-lg / shadow-sm`
    - input/select/date の高さ：`h-10`
    - border：`border-gray-200`
    - dark mode：`dark:bg-gray-500`
    - placeholder 色：`dark:placeholder-gray-200`
    - range/date の「〜」の色を統一
    - クラスを`$inputClass`にまとめて重複排除
- 詳細ページ（show）の UI 統一
    - h2：`text-2xl font-bold`
    - 編集・削除ボタンを右上に統一
    - テーブル UI を全ドメインで統一
    - `<th>`幅：`w-40`
    - `<td>`：`break-words`
    - 複数行テキスト：`whitespace-pre-line`
    - リンク生成方式：`{!! !!}` + `e()` に統一
    - 項目は foreach で管理し保守性向上
    - 戻るボタンの位置を統一
    - カード外枠に`border`を追加
- 新規作成（create）・編集（edit）ページの統一
    - h2：`text-2xl font-bold`
    - カード UI：`border / shadow-sm / rounded-lg`
    - セクション構造：`<div class="space-y-6">`
    - フォーム余白：`space-y-6`に統一
    - h3：`text-lg font-semibold`
    - ボタンの並び：primary → secondary
- コンポーネントの統一
    - x-input / x-select / x-textarea の class を配列形式に統一
    - ボタンコンポーネントの class を統一
    - 検索コンポーネントのラベル・placeholder の色を統一
    - x-customer.project-list / interaction-list のテーブル UI を統一

### 実装手順

1. 導線の改善

- トップページのリダイレクト設定
    - `web.php`の`/`にアクセスがあった場合、ログイン画面（`/login`）へリダイレクトするように変更
    - 業務システムとして一般的なトップページを排除し、ログイン前提の導線に統一
- ログイン画面の改善
    - `auth/login.blade.php`にユーザー新規登録（`/register`）へのリンクを追加
    - リンク同士の間隔が詰まらないようにレイアウトを調整（`flex`→`space-x`など）
- ログイン後の遷移先の変更
    - `web.php`の`/dashboard`にアクセスがあった場合、顧客一覧（`customers.index`）へリダイレクトするように変更
    - ログイン後に最も利用頻度の高い画面へ直接遷移する導線に改善

2. ナビゲーションバーの改善

- ログイン後のナビゲーションバーを業務システム向けに整理
    - Breeze のデフォルトである「Dashboard」を削除し、業務で利用する主要メニューに置き換え
- 主要メニューの追加
    - 顧客一覧（`customers.index`）
    - 案件一覧（`projects.index`）
    - 対応履歴一覧（`interactions.index`）
    - プロフィール（既存のまま）
    - ログアウト（既存のまま）
    - active 状態の統一（既存のまま）
- `request()->routeIs('customers.*')`のように、関連画面すべてでメニューがハイライトされるように調整
    - 一覧・新規作成・編集など CRUD 全体で統一されたナビゲーションを実現

3. テーブルの軽微な UI 改善（全一覧画面）

- 行ホバーの追加
    - `hover:bg-gray-100 dark:hover:bg-gray-600` を適用し、行選択時の視認性を向上
- odd/even の背景色統一
    - `odd:bg-white even:bg-gray-50`（dark mode 対応含む）で可読性を改善
- border 色の統一
    - `border-gray-200 dark:border-gray-600`に統一し、一覧全体の見た目を揃える
- padding の統一
    - `<th>`と`<td>`を`px-4 py-2`に統一し、セル間の余白を整える
- ヘッダー背景色の統一
    - `<thead>`に`bg-gray-100 dark:bg-gray-700`を適用し、見出しの視認性を改善
- テーブル幅の統一
    - `min-w-full`を使用し、画面幅にフィットする安定したレイアウトに統一
- 見出し（h2）の統一
    - すべての一覧ページでタイトルを`text-2xl font-bold text-gray-800 dark:text-gray-200`に統一し、視認性を向上
- カード外枠の統一
    - `border` の追加
- テーブル外枠の統一
    - border 色を`dark:border-gray-600`に統一

4. ボタンの UI 統一（全 CRUD 画面）

- primary / secondary / danger の UI を統一
    - 余白（`px-4 py-2`）
    - フォント（`text-sm font-medium`）
    - 角丸（`rounded-md`）
    - inline-block の統一
- hover / dark:hover の統一
    - primary：blue 系
    - secondary：gray 系
    - danger：red 系
    - dark mode でも自然な濃淡になるよう調整
- HTML の class 属性に直接記述する Laravel 標準スタイルに統一
    - UI を PHP に書かず、Blade 側で完結させることで可読性を向上
- 全 CRUD 画面に自動反映されるようコンポーネント側で統一
    - 各画面のボタンを個別に修正する必要がなく、保守性が向上

5. 検索フォームの軽微な改善（一覧画面）

- 検索フォーム全体（`x-search.form`）の改善
    - タイトルの視認性アップ（`text-base`/ 色調整）
    - 余白の調整（`p-5`）
    - カード感の強化（`border`/`rounded-lg`/`shadow-sm`）
    - ボタン位置の統一（右下 /`gap-4`）
- 入力欄（`x-search.input`）の改善
    - 高さを`h-10`に統一
    - border を`border-gray-200`に統一
    - placeholder の視認性改（`dark:placeholder-gray-200`）
    - dark mode の背景色調整（`dark:bg-gray-500`）
- セレクトボックス（`x-search.select`）の改善
    - input と高さ・余白を統一（`h-10`/`px-3`/`py-2`）
    - `border-gray-200`に統一
    - dark mode の背景色調整（`dark:bg-gray-500`）
    - 未選択 option の視認性改善
- 日付範囲入力（`x-search.date`）の改善
    - input と高さを統一（`h-10`）
    - `border-gray-200`に統一
    - dark mode の背景色調整（`dark:bg-gray-500`）
    - 「〜」の色を統一（`text-gray-600`/`dark:text-gray-300`）
    - クラスを`$inputClass`にまとめて重複を排除
- 数値範囲入力（`x-search.range`）の改善
    - input と高さを統一（`h-10`）
    - `border-gray-200`に統一
    - dark mode の背景色調整（`dark:bg-gray-500`）
    - 「〜」の色を統一（`text-gray-600`/`dark:text-gray-300`）
    - クラスを`$inputClass`にまとめて重複を排除

6. 詳細ページの軽微な改善（全詳細ページ共通）

- 見出し（h2）の統一
    - すべての詳細ページでタイトルを`text-2xl font-bold text-gray-800 dark:text-gray-200`に統一し、視認性を向上
- 編集・削除ボタンの位置統一
    - 右上に配置し、顧客詳細・案件詳細・対応履歴詳細で統一
    - ボタンは`x-button.primary`/`x-button.danger`を使用し、UI を統一
- テーブル UI の統一
    - すべての詳細ページで以下を統一
    - `min-w-full`による安定した幅
    - `border-gray-200 dark:border-gray-600`の統一
    - `px-4 py-2`の余白統一
    - `odd/even`の背景色統一
    - `odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700`
    - `<th>`の幅を`w-40`に統一し、読みやすさを向上
    - `<td>`に`break-words`を適用し、長文でも崩れないように調整
- 複数行テキストの統一
    - 案件内容・メモ・対応内容などの自由記述欄は`whitespace-pre-line`を適用し、改行を保持して表示
- リンク生成方式の統一
    - 値の段階で HTML を組み立て、`{!! !!}`で出力する方式に統一
    - 文字列は必ず`e()`でエスケープし、XSS を防止
    - 顧客名・案件名などのリンクはすべて同じ方式で生成
- 項目の管理方式の統一（`foreach`化）
    - 固定項目はすべて`foreach`でまとめて管理
    - 項目追加・削除が容易になり、保守性が向上
    - 顧客詳細・案件詳細・対応履歴詳細で統一されたコード構造に
- 戻るボタンの位置統一
    - 詳細ページ下部に`x-button.secondary`を配置し、UI を統一
- カード外枠の統一
    - `border` の追加

7. 新規作成ページの軽微な改善

- 見出し（h2）の統一
    - すべての新規作成ページで`text-2xl font-bold text-gray-800 dark:text-gray-200`に統一し、視認性を向上
- カード UI の統一
    - `bg-white dark:bg-gray-800`
    - `border border-gray-200 dark:border-gray-600`
    - `shadow-sm`
    - `rounded-lg`
    - 検索フォーム・詳細ページと同じカード UI に統一
- セクション構造の統一
    - `<div class="space-y-6">`で項目をまとめる
    - `<form class="space-y-6">`でセクション間の余白を統一
    - セクションタイトル（h3）は`text-lg font-semibold text-gray-800 dark:text-gray-200`

8. 編集ージの軽微な改善

- 見出し（h2）の統一
    - すべての編集ページで`text-2xl font-bold text-gray-800 dark:text-gray-200`に統一し、視認性を向上
- カード UI の統一
    - `bg-white dark:bg-gray-800`
    - `border border-gray-200 dark:border-gray-600`
    - `shadow-sm`
    - `rounded-lg`
    - index / show / create と同じカード UI に統一
- セクション構造の統一
    - `<div class="space-y-6">`で項目をまとめる
    - `<form class="space-y-6">`でセクション間の余白を統一
    - セクションタイトル（h3）は`text-lg font-semibold text-gray-800 dark:text-gray-200`

9. コンポーネントの軽微な改善

- 入力コンポーネントの統一
    - class 形式を配列に統一
- ボタンコンポーネントの統一
    - class 形式を配列に統一
- 検索コンポーネントの統一
    - ラベル色・placeholder 色の統一

### 確認内容

- CRUD 一連の操作（一覧 → 詳細 → 編集 → 更新 → 削除 → 戻る）が正しく動作すること
- ログイン前後の導線（`/` → `/login`、ログイン後 → 顧客一覧）が正しく動作すること
- ナビゲーションバーの遷移と active 状態が正しく反映されること
- テーブル（ソート・hover・odd/even・幅・border）が全ドメインで統一されていること
- 検索フォーム（input / select / date / range）の送信・保持・フィルタが正しく動作すること
- 詳細ページの表示（foreach、リンク遷移、複数行テキスト）が正しく動作すること
- create / edit のフォーム（必須チェック、disabled、余白統一）が正しく反映されていること

### 気づき・課題

- `Route::has()`や`routeIs()`の役割を理解し、ナビゲーション制御の仕組みを把握できた
- `__()`や`e()`の役割を理解し、翻訳・エスケープの重要性を学んだ
- 詳細ページの項目を foreach で管理することで、保守性が大幅に向上することを理解した
- `number_format()`は null を 0 と扱うため、null チェックが必要であることを学んだ
- 業務システムでは「ログイン前提の導線」「CRUD の UI 統一」が UX に直結することを実感した
- dark mode 対応やコンポーネント統一により、全体の品質が大きく向上した
- disabled input の見た目統一など、任意の改善余地は残る

---
