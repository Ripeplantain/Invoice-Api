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

        $data = [
            'item_name' => 'Item 1',
            'description' => 'Item 1 description',
            'unit_price' => 100,
            'quantity' => 15,
        ];

        $response = $this->postJson($this->privateUrl, $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Item created successfully',
                'data' => [
                    'item_name' => $data['item_name'],
                    'description' => $data['description'],
                    'unit_price' => $data['unit_price'],
                    'quantity' => $data['quantity'],
                ]
            ]);

        $this->assertDatabaseHas('items', $data);
    }
}
