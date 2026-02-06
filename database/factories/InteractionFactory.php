<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
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
        return [
            'customer_id' => Customer::factory(),
            'project_id' => Project::factory(),
            'assigned_user_id' => User::factory(),
            'type' => fake()->randomElement(['phone', 'email', 'visit', 'meeting']),
            'content' => fake()->realText(),
            'interacted_at' => fake()->datetime(),
            'memo' => fake()->realText(),
        ];
    }
}
