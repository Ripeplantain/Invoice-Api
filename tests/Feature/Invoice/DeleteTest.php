<?php

namespace Tests\Feature\Invoice;

use Tests\TestCase;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * Test the destroy method of InvoiceController.
     */
    public function testDestroy()
    {
        $invoice = Invoice::factory()->create();

        $response = $this->delete('/api/v1/invoice/' . $invoice->id);

        $response->assertStatus(200);

    }
}
