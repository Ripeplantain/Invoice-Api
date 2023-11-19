<?php

namespace Tests\Feature\Invoice;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Customer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CreateTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    private $privateUrl = '/api/v1/invoice';

    /**
     * Test creating a new invoice.
     *
     * @return void
     */
    public function testCreateInvoice()
    {
        $data = [
            'customer_id' => Customer::factory()->create()->id,
            'company_name' => $this->faker->company,
            'customer_mobile' => $this->faker->phoneNumber,
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'invoice_item' => [
                [
                    'item_id' => Item::factory()->create()->id,
                    'unit_price' => $this->faker->randomFloat(2, 0, 100),
                    'quantity' => 1,
                    'amount' => $this->faker->randomFloat(2, 0, 100),
                ],
                [
                    'item_id' => Item::factory()->create()->id,
                    'unit_price' => $this->faker->randomFloat(2, 0, 100),
                    'quantity' => 1,
                    'amount' => $this->faker->randomFloat(2, 0, 100),
                ],
            ],
        ];

        $response = $this->postJson('/api/v1/invoice', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('invoices', [
            'customer_id' => $data['customer_id'],
            'company_name' => $data['company_name'],
            'customer_mobile' => $data['customer_mobile'],
            'issue_date' => $data['issue_date'],
            'due_date' => $data['due_date'],
        ]);
    }
}
