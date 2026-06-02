<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    // 何件目の顧客を生成しているかを保持するカウンタ
    private static int $index = 0;

    public function definition(): array
    {
        // 顧客専用の日本名辞書（担当者と非重複）
        $names = [
            ['name' => '松本 大輔', 'kana' => 'マツモト ダイスケ'],
            ['name' => '加藤 真由', 'kana' => 'カトウ マユ'],
            ['name' => '石井 健二', 'kana' => 'イシイ ケンジ'],
            ['name' => '岡田 美穂', 'kana' => 'オカダ ミホ'],
            ['name' => '藤井 亮介', 'kana' => 'フジイ リョウスケ'],
            ['name' => '村上 彩香', 'kana' => 'ムラカミ アヤカ'],
            ['name' => '青木 翔太', 'kana' => 'アオキ ショウタ'],
            ['name' => '原田 里奈', 'kana' => 'ハラダ リナ'],
            ['name' => '三浦 和也', 'kana' => 'ミウラ カズヤ'],
            ['name' => '森田 千尋', 'kana' => 'モリタ チヒロ'],
            ['name' => '大野 拓海', 'kana' => 'オオノ タクミ'],
            ['name' => '平田 美月', 'kana' => 'ヒラタ ミヅキ'],
            ['name' => '西村 直樹', 'kana' => 'ニシムラ ナオキ'],
            ['name' => '中川 里緒', 'kana' => 'ナカガワ リオ'],
            ['name' => '前田 悠斗', 'kana' => 'マエダ ユウト'],
            ['name' => '島田 菜々子', 'kana' => 'シマダ ナナコ'],
            ['name' => '本田 俊介', 'kana' => 'ホンダ シュンスケ'],
            ['name' => '柴田 佳奈', 'kana' => 'シバタ カナ'],
            ['name' => '宮崎 亮太', 'kana' => 'ミヤザキ リョウタ'],
            ['name' => '川口 美咲', 'kana' => 'カワグチ ミサキ'],
        ];

        // 辞書をシャッフル（最初の1回だけ）
        static $shuffled = null;
        if ($shuffled === null) {
            $shuffled = fake()->shuffleArray($names);
        }

        // 今の index の名前を使う（重複ゼロ）
        $selected = $shuffled[self::$index % count($shuffled)];
        self::$index++;

        // 担当者（UserSeeder の 5 名からランダム）
        // テストでは Seeder が実行されず、User が存在しないため、なければ作成する
        $user = User::inRandomOrder()->first();

        if (!$user) {
            $user = User::factory()->create();
        }

        $assignedUserId = $user->id;

        // 日本語メモ辞書
        $memos = [
            '先方の都合により来月に再提案予定。',
            '担当者変更のため情報共有が必要。',
            '見積内容に関する追加質問あり。',
            '競合他社との比較検討中。',
            '次回訪問時に資料を持参すること。',
            '契約更新の可能性あり。',
            '新規プロジェクトの相談を受けた。',
        ];

        return [
            'name' => $selected['name'],
            'kana' => $selected['kana'],
            'email' => fake()->optional(0.8)->safeEmail(),
            'phone' => fake()->optional(0.8)->regexify('0[0-9]{1,3}-[0-9]{2,4}-[0-9]{4}'),
            'company_name' => fake()->optional(0.8)->company(),
            'department' => fake()->optional(0.8)->randomElement(['営業部', '総務部', '人事部', '開発部', '企画部']),
            'position' => fake()->optional(0.8)->randomElement(['部長', '課長', '係長', '主任', '担当']),
            'postal_code' => fake()->optional(0.8)->regexify('[0-9]{7}'),
            'address' => fake()->optional(0.8)->prefecture() . fake()->city() . fake()->streetAddress(),
            'address_detail' => fake()->optional(0.8)->secondaryAddress(),
            'status' => fake()->randomElement(['prospect', 'negotiation', 'won', 'lost', 'inactive']),
            'rank' => fake()->randomElement(['A', 'B', 'C']),
            'assigned_user_id' => $assignedUserId,
            'memo' => fake()->optional(0.8)->randomElement($memos),
        ];
    }
}
