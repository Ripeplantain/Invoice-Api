<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 10),
            'amount' => $this->faker->numberBetween(100, 1000),
            'invoice_id' => \App\Models\Invoice::factory(),
            'unit_price' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
