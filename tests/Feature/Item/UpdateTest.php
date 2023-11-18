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
            'item_name' => 'Item 1',
            'description' => 'Item 1 description',
            'unit_price' => 100,
            'quantity' => 15,
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
