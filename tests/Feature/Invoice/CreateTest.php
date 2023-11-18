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
        $item = Item::factory()->create();
        $customer = Customer::factory()->create();

        $data = [
            'customer_id' => $customer->id,
            'company_name' => $this->faker->company,
            'customer_mobile' => $this->faker->phoneNumber,
            'issue_date' => $this->faker->date,
            'due_date' => $this->faker->date,
            'item_id' => $item->id,
            'unit_price' => $this->faker->randomFloat(2, 0, 999999),
            'quantity' => $this->faker->randomDigit,
            'amount' => $this->faker->randomFloat(2, 0, 999999),
        ];

        $response = $this->postJson($this->privateUrl, $data);

        $response->assertStatus(201);

        $response->assertJson([
            'message' => 'Invoice created successfully',
            'data' => [
                'customer_id' => $customer->id,
                'company_name' => $data['company_name'],
                'customer_mobile' => $data['customer_mobile'],
                'issue_date' => $data['issue_date'],
                'due_date' => $data['due_date'],
                'item_id' => $item->id,
                'unit_price' => $data['unit_price'],
                'quantity' => $data['quantity'],
                'amount' => $data['amount'],
            ],
        ]);
    }
}
