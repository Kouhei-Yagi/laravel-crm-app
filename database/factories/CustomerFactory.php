<?php

namespace Database\Factories;

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
            'department' => fake()->word(),
            'position' => fake()->jobTitle(),
            'postal_code' => fake()->postcode(),
            'address' => fake()->address(),
            'address_detail' => fake()->secondaryAddress(),
            'status' => 'prospect',
            'rank' => 'A',
            'assigned_user_id' => 1,
            'memo' => fake()->realText(50),
        ];
    }
}
