<?php

namespace Tests\Feature\Invoice;

use Tests\TestCase;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RetrieveTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function testShowMethodReturnsCorrectInvoice()
    {
        $invoice = Invoice::factory()->create();

        $response = $this->get('/api/v1/invoice/' . $invoice->id);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => $invoice->toArray()
        ]);
    }

}