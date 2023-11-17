<?php

namespace Tests\Feature\Item;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RetrieveTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * Test the show method.
     *
     * @return void
     */
    public function testShow()
    {
        $item = Item::factory()->create();

        $response = $this->getJson('/api/v1/item/' . $item->id);

        $response->assertStatus(200);
    }
}
