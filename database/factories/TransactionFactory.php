<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender' => '44AA' . fake()->unique()->numberBetween(10000000, 99999999),
            'receiver' => '44AA' . fake()->unique()->numberBetween(10000000, 99999999),
            'amount' => fake()->numberBetween(1, 9),
            'currency_code' => fake()->currencyCode()
        ];
    }
}
