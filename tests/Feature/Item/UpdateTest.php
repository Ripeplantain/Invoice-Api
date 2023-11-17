<?php

namespace Tests\Feature\Item;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UpdateTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private $privateUrl = '/api/v1/item/';
    /**
     * Test the update method.
     */
    public function testUpdate()
    {
        $item = Item::factory()->create();

        $newItemData = [
            'invoice_id' => '1',
            'description' => 'Updated Item',
            'unit_price' => '1',
            'quantity' => '1',
            'amount' => '1'
        ];

        $response = $this->putJson($this->privateUrl . $item->id, $newItemData);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Item updated successfully',
            'data' => $newItemData
        ]);

        $this->assertDatabaseHas('items', $newItemData);
    }
}
