<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Customer;

class DeleteTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function testDestroy()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson('/api/v1/customer/' . $customer->id);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Customer deleted successfully'
        ]);
    }
}
?>