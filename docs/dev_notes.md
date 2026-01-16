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
