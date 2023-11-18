<?php

namespace Tests\Feature\Invoice;

use Tests\TestCase;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    /**
     * A basic feature test example.
     */
    public function testUpdateInvoice()
    {
        $invoice = Invoice::factory()->create();

        $data = [
            'customer_id' => $invoice->customer_id,
            'company_name' => $this->faker->company,
            'customer_mobile' => $this->faker->phoneNumber,
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'unit_price' => $this->faker->randomFloat(2, 0, 100),
            'quantity' => $this->faker->randomNumber(),
            'amount' => $this->faker->randomFloat(2, 0, 1000),
        ];

        $response = $this->put('/api/v1/invoice/' . $invoice->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('invoices', $data);
    }
}
