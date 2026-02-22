<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'kana' => fake()->kanaName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company_name' => fake()->company(),
            'department' => fake()->randomElement(['営業部', '総務部', '人事部', '開発部', '企画部']),
            'position' => fake()->randomElement(['部長', '課長', '係長', '主任', '担当']),
            'postal_code' => fake()->postcode(),
            'address' => fake()->prefecture() . fake()->city() . fake()->streetAddress(),
            'address_detail' => fake()->secondaryAddress(),
            'status' => fake()->randomElement(['prospect', 'negotiation', 'won', 'lost', 'inactive']),
            'rank' => fake()->randomElement(['A', 'B', 'C']),
            'assigned_user_id' => User::factory(),
            'memo' => fake()->realText(50),
        ];
    }
}
