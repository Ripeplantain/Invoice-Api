<?php

namespace Tests\Feature\Invoice;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    /**
     * A basic feature test example.
     */
    public function testUpdate()
    {
        $invoice = Invoice::factory()->create();

        $invoiceItems = InvoiceItem::factory(3)->create(['invoice_id' => $invoice->id]);

        $requestData = [
            'customer_id' => $invoice->customer_id,
            'company_name' => 'Example Company',
            'customer_mobile' => '1234567890',
            'issue_date' => '2022-01-01',
            'due_date' => '2022-01-31',
            'invoice_item' => [
                [
                    'item_id' => $invoiceItems[0]->item_id,
                    'quantity' => 2,
                    'unit_price' => 100.00,
                    'amount' => 200.00,
                ],
                [
                    'item_id' => $invoiceItems[1]->item_id,
                    'quantity' => 1,
                    'unit_price' => 100.00,
                    'amount' => 100.00,
                ],
                [
                    'item_id' => $invoiceItems[2]->item_id,
                    'quantity' => 2,
                    'unit_price' => 100.00,
                    'amount' => 200.00,
                ],
            ],
        ];

        $response = $this->put('/api/v1/invoice/' . $invoice->id, $requestData);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'customer_id',
                'company_name',
                'customer_mobile',
                'invoice_number',
                'issue_date',
                'due_date',
                'created_at',
                'updated_at',
                'invoice_items' => [
                    '*' => [
                        'id',
                        'invoice_id',
                        'item_id',
                        'unit_price',
                        'quantity',
                        'amount',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
        ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'customer_id' => $requestData['customer_id'],
            'company_name' => $requestData['company_name'],
            'customer_mobile' => $requestData['customer_mobile'],
            'issue_date' => $requestData['issue_date'],
            'due_date' => $requestData['due_date'],
        ]);
    }
}
