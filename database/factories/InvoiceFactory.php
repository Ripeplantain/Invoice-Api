<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
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
            'company_name' => $this->faker->company,
            'customer_mobile' => $this->faker->phoneNumber,
            'invoice_number' => $this->faker->unique()->numberBetween(100000, 999999),
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'item_id' => Item::factory(),
            'unit_price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1, 10),
            'amount' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
