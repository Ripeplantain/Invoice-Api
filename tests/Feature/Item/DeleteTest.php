<?php

namespace Tests\Feature\Item;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;
    /**
     * A basic feature test example.
     */
    public function testDelete()
    {
        $item = Item::factory()->create();

        $response = $this->deleteJson('/api/v1/item/' . $item->id);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Item deleted successfully'
        ]);

        $this->assertDatabaseMissing('items', [
            'id' => $item->id
        ]);
    }
}
