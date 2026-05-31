<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interaction>
 */
class InteractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 80% → 案件に紐づく履歴
        // 20% → 単発対応（project_id = null）
        $isLinkedToProject = fake()->boolean(80);

        if ($isLinkedToProject) {
            // 案件をランダムに取得
            $project = Project::inRandomOrder()->first();

            // 案件 → 顧客 → 担当者 を引き継ぐ
            $customerId = $project->customer_id;
            $assignedUserId = $project->assigned_user_id;

            $projectId = $project->id;
        } else {
            // 単発対応（project_id = null）
            $projectId = null;

            // 顧客をランダムに取得
            $customer = Customer::inRandomOrder()->first();

            $customerId = $customer->id;
            $assignedUserId = $customer->assigned_user_id;
        }

        // 日本語 content 辞書
        $contents = [
            'お電話にて要件をヒアリングしました。',
            'メールで資料を送付し、内容を説明しました。',
            '訪問して打ち合わせを実施しました。',
            '次回提案のための追加情報を確認しました。',
            '見積内容について先方より質問を受けました。',
            '契約更新に関する相談を受けました。',
            'システムの操作方法について問い合わせがありました。',
        ];

        // 日本語 memo 辞書
        $memos = [
            '対応はスムーズに完了。',
            '次回のアクションが必要。',
            '社内共有が必要な内容あり。',
            'フォローアップの連絡を予定。',
            '追加資料の準備が必要。',
        ];

        return [
            'project_id' => $projectId,
            'customer_id' => $customerId,
            'assigned_user_id' => $assignedUserId,
            'type' => fake()->randomElement(['phone', 'email', 'meeting', 'visit']),
            'content' => fake()->randomElement($contents),
            'interacted_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'memo' => fake()->optional(0.8)->randomElement($memos),
        ];
    }
}
