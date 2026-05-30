<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 顧客をランダムに取得
        $customer = Customer::inRandomOrder()->first();

        // 顧客の担当者を案件にも引き継ぐ
        $assignedUserId = $customer->assigned_user_id;

        // 案件名の辞書
        $titles = [
            '新規Webサイト制作',
            'ECサイトリニューアル',
            '業務管理システム導入',
            '広告運用サポート',
            'SEO改善プロジェクト',
            'アプリ開発支援',
            'クラウド移行プロジェクト',
            'データ分析レポート作成',
            'セキュリティ診断',
            'UI/UX改善コンサルティング',
        ];

        // 日本語 description 辞書
        $descriptions = [
            '現行サイトの課題を整理し、改善案を提案するプロジェクトです。',
            '新規サービス立ち上げに伴うシステム開発を支援します。',
            '既存業務の効率化を目的としたシステム導入案件です。',
            '広告運用の最適化を図るためのサポート業務です。',
            '検索順位向上のためのSEO改善施策を実施します。',
        ];

        // 日本語 memo 辞書
        $memos = [
            '初回打ち合わせはスムーズに進行。',
            '見積内容の再調整が必要。',
            '要件定義フェーズで追加ヒアリング予定。',
            '競合他社との比較資料を作成すること。',
            '次回ミーティングでスケジュール確定予定。',
        ];

        // 日付の整合性を保証
        $start = fake()->dateTimeBetween('-6 months', '+1 months');
        $end = fake()->dateTimeBetween($start, '+3 months');

        return [
            'title' => fake()->randomElement($titles),
            'customer_id' => $customer->id,
            'description' => fake()->optional(0.8)->randomElement($descriptions),
            'status' => fake()->randomElement(['estimating', 'proposing', 'contracted', 'lost', 'on_hold']),
            'amount' => fake()->optional(0.8)->numberBetween(100000, 3000000),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'assigned_user_id' => $assignedUserId,
            'memo' => fake()->optional(0.8)->randomElement($memos),
        ];
    }
}
