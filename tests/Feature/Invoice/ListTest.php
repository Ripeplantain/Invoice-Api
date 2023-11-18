<?php

namespace Tests\Feature\Invoice;

use Tests\TestCase;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ListTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private $privateUrl = '/api/v1/invoice';
    /**
     * A basic feature test example.
     */
    public function testList()
    {
        Invoice::factory()->count(3)->create();

        $response = $this->get($this->privateUrl);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'customer_id',
                    'invoice_number',
                    'issue_date',
                    'due_date',
                    'company_name',
                    'customer_mobile',
                    'item_id',
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
