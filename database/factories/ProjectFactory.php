<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
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
        return [
            'customer_id' => Customer::factory(),
            'title' => fake()->word(),
            'description' => fake()->text(),
            'status' => fake()->randomElement(['estimating', 'proposing', 'contracted', 'lost', 'on_hold']),
            'amount' => fake()->numberBetween(10000, 500000),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'assigned_user_id' => User::factory(),
            'memo' => fake()->text(),
        ];
    }
}
