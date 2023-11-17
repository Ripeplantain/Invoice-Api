<?php

namespace Tests\Feature\Item;

use Tests\TestCase;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;


class CreateTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private $privateUrl = '/api/v1/item';

    /**
     * Test the store method.
     */
    public function testStore()
    {
        $invoice = Invoice::factory()->create();

        $data = [
            'invoice_id' => $invoice->id,
            'description' => 'This is dummy text',
            'unit_price' => 12.50,
            'quantity' => 2,
            'amount' => 25.00,
        ];

        $response = $this->postJson($this->privateUrl, $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Item created successfully',
                'data' => [
                    'invoice_id' => $data['invoice_id'],
                    'description' => $data['description'],
                    'unit_price' => $data['unit_price'],
                    'quantity' => $data['quantity'],
                    'amount' => $data['amount'],
                ]
            ]);

        $this->assertDatabaseHas('items', $data);
    }
}
