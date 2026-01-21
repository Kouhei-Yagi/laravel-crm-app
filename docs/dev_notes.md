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

5. ビューの作成
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
