<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'currency_code' => fake()->currencyCode(),
            'type' => fake()->randomElement(['checking', 'investment']),
            'number' => '44AA' . fake()->numberBetween(10000000, 99999999),
            'balance' => fake()->numberBetween(10, 999),
        ];
    }
}
