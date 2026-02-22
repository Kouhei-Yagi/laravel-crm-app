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
        return [
            'customer_id' => Customer::factory(),
            'title' => fake()->realText(15),
            'description' => fake()->realText(80),
            'status' => fake()->randomElement(['estimating', 'proposing', 'contracted', 'lost', 'on_hold']),
            'amount' => fake()->numberBetween(10000, 500000),
            'start_date' => fake()->optional()->date(),
            'end_date' => fake()->optional()->date(),
            'assigned_user_id' => function (array $attributes) {
                return Customer::find($attributes['customer_id'])->assigned_user_id;
            },
            'memo' => fake()->realText(50),
        ];
    }
}
