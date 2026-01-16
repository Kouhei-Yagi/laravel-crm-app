# 開発メモ（dev_notes.md）

## 概要

このファイルは、開発過程での実装内容・実装手順・確認内容・気づき・課題を記録するためのメモです。
CRM アプリを構築する際に「どのように開発を進めたか」を示す補足資料として利用します。

---

## 機能名：設計フェーズ（要件整理・ER 図・テーブル定義・設計資料作成）

### 目的

-   CRM アプリ開発の前段階として、必要な要件・データ構造・設計意図を明確にする
-   実装フェーズに入る前に、迷いを減らし、再現性の高い設計資料を整備する
-   README を整え、プロジェクトの全体像を外部に示せる状態にする

### ブランチ名：**docs/initial-design**

### 実装日：2026-01-14 〜 2026-01-15

### 作成・変更ファイル

-   docs/requirements.md（新規）
-   docs/er-diagram.mmd（新規）
-   docs/table_definitions.ods（新規）
-   docs/master_values.md（新規）
-   docs/design_notes.md（新規）
-   docs/dev_notes.md（新規）
-   README.md（更新）

### 実装内容

-   要件整理ドキュメント（requirements.md）の作成
-   Mermaid を用いた ER 図（er-diagram.mmd）の作成
-   テーブル定義書（table_definitions.ods）の作成
-   マスタ値一覧（master_values.md）の作成
-   設計メモ（design_notes.md）の作成
-   開発メモ（dev_notes.md）の作成
-   README の全面整理（目的・技術構成・セットアップ・ER 図セクションなど）

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

-   docs フォルダの構成が整理され、設計資料が一元管理できたこと
-   Mermaid の ER 図が VSCode で正しく表示されること
-   README がプロジェクトの入口として十分な情報を提供していること
-   設計フェーズの内容が dev_notes.md によって再現可能な形で記録されていること

### 気づき・課題

-   Mermaid は draw.io より修正が圧倒的に楽で、Git 管理と相性が良い
-   設計資料を docs に分離することで README が読みやすくなった
-   設計メモ（design_notes.md）と開発メモ（dev_notes.md）は役割が異なるため両方必要
-   設計フェーズを丁寧に進めたことで、実装フェーズの迷いが大幅に減る見込み
-   今後は機能単位で dev_notes.md を継続的に更新していく運用が必要

---

## 機能名：Breeze 導入

### 目的

-   認証機能（ログイン・登録・パスワードリセットなど）を最小構成で素早く導入するため
-   Laravel 標準の認証フローをベースに、業務システムとして必要な「ユーザー管理の土台」を整えるため
-   Blade + Tailwind の構成を採用し、後続の CRUD 画面開発をスムーズに進めるため
-   認証まわりの実装コストを削減し、顧客・案件・対応履歴などの本質的な機能開発に集中するため
-   Breeze のディレクトリ構成・ルーティング・UI を参考に、プロジェクト全体のコード規約を揃えるため

### ブランチ名：**feature/setup-breeze**

### 実装日：2026-01-16

### 導入により生成された主なファイル

-   認証関連のルート・ビュー・コントローラ
-   Tailwind 設定ファイル
-   ダッシュボード画面

    ※ すべて Breeze により自動生成されたもの

### 実装内容

-   Breeze（Blade 版）を導入し、認証機能一式と Tailwind CSS のセットアップを追加
-   ダークモード対応を有効化
-   認証後のダッシュボード画面が利用可能に

### 実装手順

1.  **Breeze のインストール**

    ```sh
    composer require laravel/breeze --dev
    php artisan breeze:install blade
    npm install
    npm run build
    ```

### 確認内容

-   認証ルート・ビュー・コントローラが生成されていること
-   Register / Login / Logout が正常に動作すること
-   /dashboard が認証保護されていること（未ログイン時は /login にリダイレクト）
-   /register が認証後にアクセス不可であること（/dashboard にリダイレクト）
-   パスワードリセット画面が表示されること
-   認証後のダッシュボードが表示されること
-   UI が Tailwind ベースで構築されていること

    ※ パスワードリセットメール送信の実確認は今回はスキップ。

### 気づき・課題

-   Breeze の導入により認証基盤が短時間で整い、実装フェーズにスムーズに移行できる
-   パスワードリセットメールの送信確認は Mailpit などを導入すれば可能だが、現時点では優先度が低いため後回し
-   ダークモード対応は自動で付与されるため、UI 調整時に活用できる

---

## 機能名：日本語化

### 目的

-   アプリ全体の表示言語を日本語に統一し、業務システムとして自然な UI を提供するため
-   バリデーションメッセージや認証画面を日本語化し、ユーザーにとって分かりやすい操作性を実現するため
-   Faker のロケールを日本語化し、Factory や Seeder で生成されるダミーデータを日本語仕様にするため
-   タイムゾーンを JST（Asia/Tokyo）に設定し、業務システムとして正しい日時管理を行うため
-   Breeze の UI を日本語化し、後続の CRUD 開発をスムーズに進めるため

### ブランチ名：**feature/Lang-jp**

### 実装日：2026-01-16

### 作成・変更・自動生成されたファイル

-   .env（更新）
-   config/app.php（更新）
-   lang/ja/\*（新規）
-   resources/views/auth/\*（新規）
-   resources/views/layouts/\*（新規）

### 実装内容

-   Laravel のロケールを日本語（ja）に設定
-   Faker のロケールを日本語（ja_JP）に設定
-   SQLite の DB 設定を .env に明示
-   タイムゾーンを Asia/Tokyo に変更
-   Laravel Breeze の UI を日本語化（BreezeJP を使用）
-   バリデーションメッセージを日本語化（lang:publish）

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

-   ログイン画面・登録画面が日本語化されていること
-   バリデーションエラーメッセージが日本語で表示されること
-   lang/ja ディレクトリが生成されていること
-   Breeze の UI（auth, layouts）が日本語化されていること
-   テストユーザーを登録し、created_at / updated_at が JST（日本時間）で保存されていること

### 気づき・課題

-   BreezeJP により認証画面が一括で日本語化され、作業コストが大幅に削減できた
-   Faker の日本語化は Factory / Seeder 作成時に改めて確認が必要
-   .env の設定は日本語化フェーズでまとめて行うことで履歴が整理され、管理しやすくなった

---
