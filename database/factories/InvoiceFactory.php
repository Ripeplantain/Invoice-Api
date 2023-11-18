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
        ];
    }
}
