<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Item;

class ListTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function testIndex()
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/item');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'invoice_id',
                    'description',
                    'unit_price',
                    'quantity',
                    'amount',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
?>