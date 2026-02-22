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
        // 50% の確率で案件あり
        $project = fake()->boolean(50) ? Project::factory()->create() : null;

        return [
            'customer_id' => $project ? $project->customer_id : Customer::factory(),
            'project_id' => $project?->id,
            'assigned_user_id' => function (array $attributes) {
                return Customer::find($attributes['customer_id'])->assigned_user_id;
            },
            'type' => fake()->randomElement(['phone', 'email', 'visit', 'meeting']),
            'content' => fake()->realText(80),
            'interacted_at' => fake()->datetime(),
            'memo' => fake()->realText(50),
        ];
    }
}
